<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupMessageSent implements ShouldBroadcast
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Message $message
    ) {
        $this->message->load([
            'sender',
            'group',
        ]);
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(
                'chat-group.' . $this->message->chat_group_id
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'group-message-sent';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,

            'sender_id' =>
                $this->message->sender_id,

            'sender_name' =>
                $this->message->sender?->name,

            'chat_group_id' =>
                $this->message->chat_group_id,

            'message' =>
                $this->message->message,

            'file' =>
                $this->message->file,

            'created_at' =>
                $this->message->created_at?->toISOString(),
        ];
    }
}