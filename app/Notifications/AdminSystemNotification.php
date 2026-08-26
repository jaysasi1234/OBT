<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AdminSystemNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $title,
        protected string $message,
        protected string $icon = '🔔',
        protected ?string $url = null,
        protected ?int $senderId = null,
    ) {
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
     * Data stored in the notifications table.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title'     => $this->title,
            'message'   => $this->message,
            'icon'      => $this->icon,
            'url'       => $this->url,
            'sender_id' => $this->senderId,
        ];
    }

    /**
     * Data sent through Laravel Reverb / Echo.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        \Log::info('Broadcast notification fired.', [
            'user_id' => $notifiable->id,
            'title'   => $this->title,
            'message' => $this->message,
        ]);

        return new BroadcastMessage([
            'title'     => $this->title,
            'message'   => $this->message,
            'icon'      => $this->icon,
            'url'       => $this->url,
            'sender_id' => $this->senderId,
        ]);
    }

    /**
     * Fallback array representation.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title'     => $this->title,
            'message'   => $this->message,
            'icon'      => $this->icon,
            'url'       => $this->url,
            'sender_id' => $this->senderId,
        ];
    }
}