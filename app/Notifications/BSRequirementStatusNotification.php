<?php

namespace App\Notifications;

use App\Models\Cadet;
use App\Models\BSRequirement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class BSRequirementStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Cadet $cadet,
        public BSRequirement $requirement,
        public string $status,
        public ?string $remarks = null
    ) {
    }

    /**
     * Notification channels.
     */
    public function via($notifiable): array
    {
        return [
            'database',
            'broadcast',
        ];
    }

    /**
     * Database notification.
     */
    public function toDatabase($notifiable): array
    {
        $status = ucfirst(
            strtolower($this->status)
        );

        $isApproved =
            strtolower($this->status) === 'approved';

        return [

            'type' => 'bs_requirement_status',

            'title' => $isApproved
                ? 'BS Requirement Approved'
                : 'BS Requirement Rejected',

            'message' =>
                'Your BS requirement "' .
                (
                    $this->requirement->title
                    ?? 'Requirement'
                ) .
                '" has been ' .
                strtolower($status) .
                '.',

            'cadet_id' =>
                $this->cadet->id,

            'requirement_id' =>
                $this->requirement->id,

            'requirement_title' =>
                $this->requirement->title,

            'status' =>
                $status,

            'remarks' =>
                $this->remarks,

            /*
             * IMPORTANT:
             * Your Cadet Dashboard route is `dashboard`,
             * not `cadet.dashboard`.
             */
            'url' =>
                route('cadet.bs.requirements'),

            'icon' =>
                $isApproved
                    ? 'fa-circle-check'
                    : 'fa-circle-xmark',

            'color' =>
                $isApproved
                    ? 'green'
                    : 'red',
        ];
    }


    /**
     * Realtime broadcast notification.
     */
    public function toBroadcast(User $notifiable): BroadcastMessage
    {
        return (new BroadcastMessage(
            $this->toDatabase($notifiable)
        ))
        ->onConnection('sync');
    }

}