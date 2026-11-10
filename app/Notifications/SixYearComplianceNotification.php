<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class SixYearComplianceNotification extends Notification
{
    use Queueable;

    protected string $issue;
    protected array $cadetData;
    protected bool $forAdmin;

    public function __construct(
        string $issue,
        array $cadetData,
        bool $forAdmin = false
    ) {
        $this->issue = $issue;
        $this->cadetData = $cadetData;
        $this->forAdmin = $forAdmin;
    }

    /**
     * Notification channels.
     */
    public function via(object $notifiable): array
    {
        return [
            'database',
            'broadcast',
        ];
    }

    /**
     * Build notification data.
     */
    private function notificationData(object $notifiable): array
    {
        $name = $this->cadetData['name'];
        $trb = $this->cadetData['trb_no'];

        if ($this->issue === 'obt') {
            $title = '6-Year OBT Deployment Warning';

            $message = $this->forAdmin
                ? "{$name} ({$trb}) has reached six years since registration but has no recorded OBT deployment."
                : "You have reached six years since registration, but you have no recorded OBT deployment. Please coordinate with the OBT Office.";

            $icon = '🚢';
            $eventKey = 'six_year_obt';

        } else {
            $title = '6-Year BS Requirements Warning';

            $message = $this->forAdmin
                ? "{$name} ({$trb}) has reached six years since registration but still has incomplete BS requirements."
                : "You have reached six years since registration, but your BS requirements remain incomplete. Please coordinate with the OBT Office.";

            $icon = '🎓';
            $eventKey = 'six_year_bs';
        }

        // Determine notification destination.
        if (!$this->forAdmin) {
            $url = route('cadet.notifications');
        } elseif (($notifiable->role ?? null) === 'dean') {
            $url = route('superadmin.notifications');
        } else {
            $url = route('admin.notifications');
        }

        // Prevent duplicate notifications for the same issue.
        if ($this->forAdmin) {
            $eventKey .= '_cadet_' . $this->cadetData['id'];
        }

        return [
            'title'      => $title,
            'message'    => $message,
            'icon'       => $icon,
            'url'        => $url,
            'sender_id'  => null,

            // Additional compliance information.
            'event_key'  => $eventKey,
            'issue'      => $this->issue,
            'cadet_id'   => $this->cadetData['id'],
            'cadet_name' => $name,
            'trb_no'     => $trb,
            'for_admin'  => $this->forAdmin,
        ];
    }

    /**
     * Data stored in the notifications table.
     */
    public function toDatabase(object $notifiable): array
    {
        return $this->notificationData($notifiable);
    }

    /**
     * Data sent through Laravel Reverb / Echo.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $data = $this->notificationData($notifiable);

        \Log::info('Six-year compliance notification broadcast fired.', [
            'user_id' => $notifiable->id,
            'title'   => $data['title'],
            'issue'   => $this->issue,
        ]);

        return new BroadcastMessage($data);
    }

    /**
     * Fallback array representation.
     */
    public function toArray(object $notifiable): array
    {
        return $this->notificationData($notifiable);
    }
}
