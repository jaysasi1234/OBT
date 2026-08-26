<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class NotificationCreated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;


    public string $message;


    public function __construct(string $message)
    {
        $this->message = $message;
    }


    public function broadcastOn(): array
    {
        return [
            new Channel('notifications')
        ];
    }


    public function broadcastAs(): string
    {
        return 'notification.created';
    }
}