<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable;
    use SerializesModels;

    public Message $message;

    public function __construct(
        Message $message
    ) {
        $this->message =
            $message->load([
                'sender',
                'receiver',
                'group',
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CHANNELS
    |--------------------------------------------------------------------------
    */

    public function broadcastOn(): array
    {
        /*
        |--------------------------------------------------------------------------
        | GROUP CHAT
        |--------------------------------------------------------------------------
        */

        if ($this->message->chat_group_id) {

            $members =
                $this->message
                    ->group
                    ->members()
                    ->pluck('user_id');


            return $members
                ->map(function ($userId) {

                    return new PrivateChannel(
                        'chat.user.' . $userId
                    );

                })
                ->all();
        }


        /*
        |--------------------------------------------------------------------------
        | DIRECT CHAT
        |--------------------------------------------------------------------------
        */

        return [

            new PrivateChannel(
                'chat.user.' .
                $this->message->sender_id
            ),

            new PrivateChannel(
                'chat.user.' .
                $this->message->receiver_id
            ),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | EVENT NAME
    |--------------------------------------------------------------------------
    */

    public function broadcastAs(): string
    {
        return 'message.sent';
    }


    /*
    |--------------------------------------------------------------------------
    | PAYLOAD
    |--------------------------------------------------------------------------
    */

    public function broadcastWith(): array
    {
        return [

            'id' =>
                $this->message->id,

            'sender_id' =>
                $this->message->sender_id,

            'receiver_id' =>
                $this->message->receiver_id,

            'chat_group_id' =>
                $this->message->chat_group_id,

            'message' =>
                $this->message->message,

            'file' =>
                $this->message->file,

            'is_read' =>
                $this->message->is_read,

            'is_delivered' =>
                $this->message->is_delivered,

            'read_at' =>
                $this->message->read_at,

            'delivered_at' =>
                $this->message->delivered_at,

            'created_at' =>
                $this->message->created_at,

            'sender' => $this->message->sender
                ? [
                    'id' =>
                        $this->message
                            ->sender
                            ->id,

                    'name' =>
                        $this->message
                            ->sender
                            ->name,
                ]
                : null,

        ];
    }
}