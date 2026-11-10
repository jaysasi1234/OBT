<?php

namespace App\Console\Commands;

use App\Models\Cadet;
use App\Models\User;
use App\Notifications\SixYearComplianceNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckSixYearCompliance extends Command
{
    protected $signature = 'obt:check-six-year-compliance {--dry-run : Preview notifications without sending them}';

    protected $description = 'Check six-year OBT and BS compliance';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        $this->info('Starting six-year compliance monitoring...');

        if ($dryRun) {
            $this->warn('DRY-RUN MODE: No notifications will be sent.');
        }

        $cutoffDate = now()->subYears(6);

        $adminUsers = User::whereIn('role', ['admin', 'dean'])
            ->where('is_active', true)
            ->get();

        $checked = 0;
        $obtAlerts = 0;
        $bsAlerts = 0;
        $notifications = 0;

        Cadet::with(['user', 'deployment', 'bsRequirements'])
            ->whereNotNull('created_at')
            ->where('created_at', '<=', $cutoffDate)
            ->chunkById(100, function ($cadets) use (
                $adminUsers,
                $dryRun,
                &$checked,
                &$obtAlerts,
                &$bsAlerts,
                &$notifications
            ) {
                foreach ($cadets as $cadet) {
                    $checked++;

                    $cadetData = [
                        'id' => $cadet->id,
                        'name' => $cadet->full_name
                            ?: $cadet->user?->name
                            ?: 'Unknown Cadet',
                        'trb_no' => $cadet->trb_control_number ?: 'N/A',
                    ];

                    // OBT: Check actual deployment status.
                    $deploymentStatus = strtolower(
                        trim($cadet->deployment?->status ?? '')
                    );

                    $hasBeenDeployed = in_array(
                        $deploymentStatus,
                        ['ongoing', 'completed'],
                        true
                    );

                    if (!$hasBeenDeployed) {
                        $obtAlerts++;

                        if (!$dryRun) {
                            if ($cadet->user) {
                                $notifications += (int) $this->sendOnce(
                                    $cadet->user,
                                    'obt',
                                    $cadetData,
                                    false
                                );
                            }

                            foreach ($adminUsers as $admin) {
                                $notifications += (int) $this->sendOnce(
                                    $admin,
                                    'obt',
                                    $cadetData,
                                    true
                                );
                            }
                        }
                    }

                    // BS: Check all BS requirements.
                    $requirements = $cadet->bsRequirements;

                    $bsCompleted = $requirements->isNotEmpty()
                        && $requirements->every(function ($requirement) {
                            return in_array(
                                strtolower(trim($requirement->status ?? '')),
                                ['approved', 'completed'],
                                true
                            );
                        });

                    if (!$bsCompleted) {
                        $bsAlerts++;

                        if (!$dryRun) {
                            if ($cadet->user) {
                                $notifications += (int) $this->sendOnce(
                                    $cadet->user,
                                    'bs',
                                    $cadetData,
                                    false
                                );
                            }

                            foreach ($adminUsers as $admin) {
                                $notifications += (int) $this->sendOnce(
                                    $admin,
                                    'bs',
                                    $cadetData,
                                    true
                                );
                            }
                        }
                    }
                }
            });

        $this->newLine();
        $this->info('Six-year compliance checking completed.');

        $this->table(
            ['Monitoring Information', 'Total'],
            [
                ['Monitoring Mode', $dryRun ? 'DRY RUN' : 'LIVE'],
                ['Eligible cadets checked', $checked],
                ['Cadets requiring OBT attention', $obtAlerts],
                ['Cadets requiring BS attention', $bsAlerts],
                ['Notifications sent', $notifications],
            ]
        );

        if ($dryRun) {
            $this->comment('Preview only. No notifications were sent.');
        }

        return self::SUCCESS;
    }

    private function sendOnce(
        User $recipient,
        string $issue,
        array $cadetData,
        bool $forAdmin
    ): bool {
        $eventKey = 'six_year_' . $issue;

        if ($forAdmin) {
            $eventKey .= '_cadet_' . $cadetData['id'];
        }

        $alreadySent = DB::table('notifications')
            ->where('notifiable_type', get_class($recipient))
            ->where('notifiable_id', $recipient->id)
            ->where('type', SixYearComplianceNotification::class)
            ->whereJsonContains('data->event_key', $eventKey)
            ->exists();

        if ($alreadySent) {
            return false;
        }

        $recipient->notify(
            new SixYearComplianceNotification(
                $issue,
                $cadetData,
                $forAdmin
            )
        );

        return true;
    }
}
