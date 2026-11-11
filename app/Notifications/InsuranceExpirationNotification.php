<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class InsuranceExpirationNotification extends Notification
{
    use Queueable;

    protected string $title;
    protected string $message;
    protected string $icon;
    protected string $url;
    protected string $eventKey;

    public function __construct(
        string $title,
        string $message,
        string $icon,
        string $url,
        string $eventKey
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->icon = $icon;
        $this->url = $url;
        $this->eventKey = $eventKey;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase(object $notifiable): array
    {
        return $this->notificationData();
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->notificationData());
    }

    protected function notificationData(): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'url' => $this->url,
            'sender_id' => null,
            'event_key' => $this->eventKey,
            'type' => 'insurance_expiration',
        ];
    }
}
