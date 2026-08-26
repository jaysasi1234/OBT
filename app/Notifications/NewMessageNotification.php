<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewMessageNotification extends Notification
{
    /**
     * Notification data.
     */
    public string $message;

    public int $senderId;

    public string $senderName;

    public string $receiverRole;

    /**
     * Group information.
     */
    public ?int $groupId;

    public ?string $groupName;

    /**
     * Create notification.
     *
     * Supports:
     *
     * DIRECT MESSAGE
     * ----------------
     * groupId = null
     *
     * GROUP MESSAGE
     * ----------------
     * groupId = group ID
     * groupName = group name
     */
    public function __construct(
        string $message,
        int $senderId,
        string $senderName,
        string $receiverRole,
        ?int $groupId = null,
        ?string $groupName = null
    ) {
        $this->message = $message;

        $this->senderId = $senderId;

        $this->senderName = $senderName;

        $this->receiverRole = strtolower(
            trim($receiverRole)
        );

        $this->groupId = $groupId;

        $this->groupName = $groupName;
    }


    /**
     * Determine whether this is a group notification.
     */
    public function isGroupMessage(): bool
    {
        return !is_null($this->groupId);
    }


    /**
     * Notification delivery channels.
     */
    public function via(object $notifiable): array
    {
        return [
            'database',
            'broadcast',
        ];
    }


    /**
     * Get notification URL.
     */
    protected function getChatUrl(
        object $notifiable
    ): string {

        /*
        |--------------------------------------------------------------------------
        | GROUP CHAT
        |--------------------------------------------------------------------------
        */

        if ($this->isGroupMessage()) {

            return $notifiable->role === 'dean'
                ? route(
                    'superadmin.chat',
                    [
                        'type' =>
                            'group',

                        'group_id' =>
                            $this->groupId,
                    ]
                )
                : route(
                    'chat.index',
                    [
                        'type' =>
                            'group',

                        'group_id' =>
                            $this->groupId,
                    ]
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DIRECT CHAT
        |--------------------------------------------------------------------------
        */

        return $notifiable->role === 'dean'
            ? route(
                'superadmin.chat',
                [
                    'type' =>
                        'direct',

                    'receiver_id' =>
                        $this->senderId,
                ]
            )
            : route(
                'chat.index',
                [
                    'type' =>
                        'direct',

                    'receiver_id' =>
                        $this->senderId,
                ]
            );
    }


    /**
     * Broadcast notification.
     */
    public function toBroadcast(
        object $notifiable
    ): BroadcastMessage {

        $url =
            $this->getChatUrl(
                $notifiable
            );


        /*
        |--------------------------------------------------------------------------
        | GROUP MESSAGE
        |--------------------------------------------------------------------------
        */

        if ($this->isGroupMessage()) {

            return new BroadcastMessage([

                'type' =>
                    'group_chat',

                'message' =>
                    $this->senderName .
                    ' in ' .
                    $this->groupName .
                    ': ' .
                    $this->message,

                'icon' =>
                    '👥',

                'url' =>
                    $url,

                'sender_id' =>
                    $this->senderId,

                'sender_name' =>
                    $this->senderName,

                'group_id' =>
                    $this->groupId,

                'group_name' =>
                    $this->groupName,

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | DIRECT MESSAGE
        |--------------------------------------------------------------------------
        */

        return new BroadcastMessage([

            'type' =>
                'chat',

            'message' =>
                $this->senderName .
                ': ' .
                $this->message,

            'icon' =>
                '💬',

            'url' =>
                $url,

            'sender_id' =>
                $this->senderId,

            'sender_name' =>
                $this->senderName,

        ]);
    }


    /**
     * Database notification.
     */
    public function toDatabase(
        object $notifiable
    ): array {

        $url =
            $this->getChatUrl(
                $notifiable
            );


        /*
        |--------------------------------------------------------------------------
        | GROUP MESSAGE
        |--------------------------------------------------------------------------
        */

        if ($this->isGroupMessage()) {

            return [

                'type' =>
                    'group_chat',

                'message' =>
                    $this->senderName .
                    ' in ' .
                    $this->groupName .
                    ': ' .
                    $this->message,

                'icon' =>
                    '👥',

                'url' =>
                    $url,

                'sender_id' =>
                    $this->senderId,

                'sender_name' =>
                    $this->senderName,

                'group_id' =>
                    $this->groupId,

                'group_name' =>
                    $this->groupName,

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | DIRECT MESSAGE
        |--------------------------------------------------------------------------
        */

        return [

            'type' =>
                'chat',

            'message' =>
                $this->senderName .
                ': ' .
                $this->message,

            'icon' =>
                '💬',

            'url' =>
                $url,

            'sender_id' =>
                $this->senderId,

            'sender_name' =>
                $this->senderName,

        ];
    }


    /**
     * Array representation.
     */
    public function toArray(
        object $notifiable
    ): array {

        return $this->toDatabase(
            $notifiable
        );
    }
}