<?php

namespace App\Console\Commands;

use App\Models\CadetInsurance;
use App\Models\User;
use App\Notifications\InsuranceExpirationNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class CheckInsuranceExpiration extends Command
{
    protected $signature = 'obt:check-insurance-expiration
                            {--dry-run : Preview notifications without sending them}';

    protected $description = 'Notify admins and cadets about insurance expiration';

    public function handle(): int
    {
        $today = today();
        $warningDate = today()->addDays(30);

        $dryRun = (bool) $this->option('dry-run');

        // Admin accounts that should receive insurance notifications.
        $admins = User::query()
            ->where('role', 'admin')
            ->get();

        $warningsSent = 0;
        $expiredSent = 0;
        $skipped = 0;

        /*
         * =====================================================
         * 1. INSURANCE EXPIRING WITHIN 30 DAYS
         * =====================================================
         */

        CadetInsurance::with(['cadet.user'])
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '>', $today)
            ->whereDate('expiration_date', '<=', $warningDate)
            ->whereNull('expiry_warning_sent_at')
            ->chunkById(100, function ($insurances) use (
                $admins,
                $dryRun,
                &$warningsSent,
                &$skipped
            ) {
                foreach ($insurances as $insurance) {

                    $cadet = $insurance->cadet;
                    $cadetUser = $cadet?->user;

                    if (!$cadet || !$cadetUser) {
                        $this->warn(
                            "Skipped insurance ID {$insurance->id}: cadet account not found."
                        );

                        $skipped++;
                        continue;
                    }

                    $daysRemaining = (int) today()->diffInDays(
                        $insurance->expiration_date->copy()->startOfDay(),
                        false
                    );

                    $message = $cadet->full_name .
                        "'s insurance will expire in {$daysRemaining} day(s).";

                    $eventKey = 'insurance-expiring-' .
                        $insurance->id . '-' .
                        $insurance->expiration_date->format('Ymd');

                    if ($dryRun) {
                        $this->line(
                            "[DRY RUN] EXPIRING SOON: {$message}"
                        );

                        $warningsSent++;
                        continue;
                    }

                    $this->sendNotifications(
                        $admins,
                        $cadetUser,
                        'Insurance Expiring Soon',
                        $message,
                        'fa-solid fa-shield-halved',
                        $eventKey,
                        $cadet->id
                    );

                    $insurance->update([
                        'expiry_warning_sent_at' => now(),
                    ]);

                    $warningsSent++;
                }
            });

        /*
         * =====================================================
         * 2. ALREADY EXPIRED INSURANCE
         * =====================================================
         */

        CadetInsurance::with(['cadet.user'])
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<=', $today)
            ->whereNull('expired_notified_at')
            ->chunkById(100, function ($insurances) use (
                $admins,
                $dryRun,
                &$expiredSent,
                &$skipped
            ) {
                foreach ($insurances as $insurance) {

                    $cadet = $insurance->cadet;
                    $cadetUser = $cadet?->user;

                    if (!$cadet || !$cadetUser) {
                        $this->warn(
                            "Skipped insurance ID {$insurance->id}: cadet account not found."
                        );

                        $skipped++;
                        continue;
                    }

                    $message = $cadet->full_name .
                        "'s insurance has expired.";

                    $eventKey = 'insurance-expired-' .
                        $insurance->id . '-' .
                        $insurance->expiration_date->format('Ymd');

                    if ($dryRun) {
                        $this->line(
                            "[DRY RUN] EXPIRED: {$message}"
                        );

                        $expiredSent++;
                        continue;
                    }

                    $this->sendNotifications(
                        $admins,
                        $cadetUser,
                        'Insurance Expired',
                        $message,
                        'fa-solid fa-triangle-exclamation',
                        $eventKey,
                        $cadet->id
                    );

                    $insurance->update([
                        'expired_notified_at' => now(),
                    ]);

                    $expiredSent++;
                }
            });

        $this->newLine();

        $this->info('Insurance expiration check completed.');

        $this->table(
            ['Result', 'Count'],
            [
                ['Expiring Soon', $warningsSent],
                ['Expired', $expiredSent],
                ['Skipped', $skipped],
            ]
        );

        return self::SUCCESS;
    }

    /**
     * Send the same event to admin accounts and the affected cadet.
     */
    private function sendNotifications(
        $admins,
        User $cadetUser,
        string $title,
        string $message,
        string $icon,
        string $eventKey,
        int $cadetId
    ): void {
        $adminUrl = route('admin.verification.show', $cadetId);

        // Cadets are directed to their own dashboard.
        $cadetUrl = route('dashboard');

        $notificationForAdmin = new InsuranceExpirationNotification(
            $title,
            $message,
            $icon,
            $adminUrl,
            $eventKey
        );

        $notificationForCadet = new InsuranceExpirationNotification(
            $title,
            $message,
            $icon,
            $cadetUrl,
            $eventKey
        );

        Notification::send($admins, $notificationForAdmin);

        $cadetUser->notify($notificationForCadet);
    }
}
