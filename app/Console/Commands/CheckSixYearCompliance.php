<?php

namespace App\Console\Commands;

use App\Models\Cadet;
use App\Notifications\CadetRequirementSubmitted;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class CheckSixYearCompliance extends Command
{
    protected $signature = 'obt:check-six-year-compliance
                            {--dry-run : Check compliance without sending notifications}';

    protected $description = 'Check cadets who have reached six years and verify their onboard and BS requirements';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        $cutoffDate = Carbon::now()->subYears(6);

        $this->info('Starting six-year compliance check...');
        $this->info('Cutoff date: ' . $cutoffDate->toDateString());

        if ($dryRun) {
            $this->warn('DRY RUN MODE: No notifications will be sent.');
        }

        $cadets = Cadet::with([
            'user',
            'deployment',
            'bsRequirements',
        ])
            ->whereDate('created_at', '<=', $cutoffDate)
            ->get();

        $checked = 0;
        $qualified = 0;
        $notQualified = 0;
        $notificationsSent = 0;

        foreach ($cadets as $cadet) {
            $checked++;

            $deployment = $cadet->deployment;

            $deploymentCompleted = $deployment
                && strtolower((string) $deployment->status) === 'completed';

            $bsRequirements = $cadet->bsRequirements ?? collect();

            $allBsRequirementsCompleted = $bsRequirements->isNotEmpty()
                && $bsRequirements->every(function ($requirement) {
                    return in_array(
                        strtolower((string) $requirement->status),
                        ['approved', 'completed'],
                        true
                    );
                });

            $isCompliant = $deploymentCompleted && $allBsRequirementsCompleted;

            if ($isCompliant) {
                $qualified++;
                $this->line(
                    "COMPLIANT: {$cadet->full_name} (ID: {$cadet->id})"
                );

                continue;
            }

            $notQualified++;

            $this->warn(
                "NOT COMPLIANT: {$cadet->full_name} (ID: {$cadet->id})"
            );

            if (!$cadet->user) {
                $this->warn('No linked user account. Notification skipped.');
                continue;
            }

            $eventKey = 'six_year_compliance_' . $cadet->id;

            $alreadyNotified = DB::table('notifications')
                ->where('notifiable_type', get_class($cadet->user))
                ->where('notifiable_id', $cadet->user->id)
                ->where('data', 'like', '%' . $eventKey . '%')
                ->exists();

            if ($alreadyNotified) {
                $this->line('Notification already sent. Skipping.');
                continue;
            }

            if ($dryRun) {
                $this->line('DRY RUN: Notification would be sent.');
                continue;
            }

            /*
             * Send notification only when the notification class
             * supports the required notification message.
             *
             * Do not use CadetRequirementSubmitted here unless
             * it is designed for this six-year compliance event.
             */
            $this->warn(
                'Notification not sent: configure a dedicated six-year compliance notification.'
            );
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
