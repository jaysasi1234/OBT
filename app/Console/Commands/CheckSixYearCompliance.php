<?php

namespace App\Console\Commands;

use App\Models\Cadet;
use App\Models\User;
use App\Notifications\SixYearComplianceNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CheckSixYearCompliance extends Command
{
    protected $signature = 'obt:check-six-year-compliance
                            {--dry-run : Check without sending notifications}
                            {--test-only : Send notifications only to test_sixyear}';

    protected $description = 'Check six-year OBT and BS compliance and notify affected accounts';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $testOnly = (bool) $this->option('test-only');

        $cutoffDate = Carbon::now()->subYears(6);

        $this->info('Starting six-year compliance check...');
        $this->info('Cutoff date: ' . $cutoffDate->toDateString());

        if ($dryRun) {
            $this->warn('DRY RUN: No notifications will be sent.');
        }

        if ($testOnly && $dryRun) {
            $this->error('Use either --dry-run or --test-only, not both.');
            return self::FAILURE;
        }

        if ($testOnly) {
            $this->warn('TEST MODE: Only test_sixyear will receive notifications.');
        }

        $query = Cadet::with([
            'user',
            'deployment',
            'bsRequirements',
        ])->whereDate('created_at', '<=', $cutoffDate->toDateString());

        if ($testOnly) {
            $query->whereHas('user', function ($q) {
                $q->where('username', 'test_sixyear')
                  ->where('role', 'cadet');
            });
        }

        $cadets = $query->get();

        $checked = 0;
        $qualified = 0;
        $notQualified = 0;
        $notificationsSent = 0;

        foreach ($cadets as $cadet) {
            $checked++;

            $deploymentCompleted = $cadet->deployment
                && strtolower((string) $cadet->deployment->status) === 'completed';

            $bsRequirements = $cadet->bsRequirements ?? collect();

            $allBsRequirementsCompleted = $bsRequirements->isNotEmpty()
                && $bsRequirements->every(function ($requirement) {
                    return in_array(
                        strtolower((string) $requirement->status),
                        ['approved', 'completed'],
                        true
                    );
                });

            $issues = [];

            if (!$deploymentCompleted) {
                $issues[] = 'obt';
            }

            if (!$allBsRequirementsCompleted) {
                $issues[] = 'bs';
            }

            if (empty($issues)) {
                $qualified++;
                $this->line("COMPLIANT: {$cadet->full_name} (ID: {$cadet->id})");
                continue;
            }

            $notQualified++;

            $this->warn("NOT COMPLIANT: {$cadet->full_name} (ID: {$cadet->id})");

            if (!$cadet->user) {
                $this->warn('No linked user account. Skipping notifications.');
                continue;
            }

            $cadetData = [
                'id' => $cadet->id,
                'name' => $cadet->full_name,
                'trb_no' => $cadet->trb_control_number ?? 'N/A',
            ];

            foreach ($issues as $issue) {
                $eventKey = 'six_year_' . $issue;

                // Check whether this cadet already received this issue.
                $alreadyNotified = DB::table('notifications')
                    ->where('notifiable_type', User::class)
                    ->where('notifiable_id', $cadet->user->id)
                    ->where('data', 'like', '%' . $eventKey . '%')
                    ->exists();

                if ($alreadyNotified) {
                    $this->line("Already notified: {$issue} for {$cadet->full_name}");
                    continue;
                }

                if ($dryRun) {
                    $this->line("DRY RUN: {$issue} notification would be sent.");
                    continue;
                }

                // Notify the affected cadet.
                $cadet->user->notify(
                    new SixYearComplianceNotification($issue, $cadetData)
                );

                $notificationsSent++;

                $this->info("Cadet notification sent: {$issue}");

                // In test mode, never notify real administrators.
                if ($testOnly) {
                    continue;
                }

                // Notify active Admin and Dean accounts.
                $admins = User::whereIn('role', ['admin', 'dean'])
                    ->where('is_active', true)
                    ->get();

                foreach ($admins as $admin) {
                    $adminEventKey = $eventKey . '_cadet_' . $cadet->id;

                    $adminAlreadyNotified = DB::table('notifications')
                        ->where('notifiable_type', User::class)
                        ->where('notifiable_id', $admin->id)
                        ->where('data', 'like', '%' . $adminEventKey . '%')
                        ->exists();

                    if ($adminAlreadyNotified) {
                        continue;
                    }

                    Notification::send(
                        $admin,
                        new SixYearComplianceNotification($issue, $cadetData, true)
                    );

                    $notificationsSent++;
                }
            }
        }

        $this->newLine();

        $this->info('Six-year compliance check completed.');

        $this->table(
            ['Description', 'Count'],
            [
                ['Cadets checked', $checked],
                ['Compliant', $qualified],
                ['Not compliant', $notQualified],
                ['Notifications sent', $notificationsSent],
            ]
        );

        return self::SUCCESS;
    }
}
