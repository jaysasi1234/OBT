<?php

namespace App\Notifications;

use App\Models\Cadet;
use App\Models\OnboardRequirement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class OnboardRequirementStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Cadet $cadet,
        public OnboardRequirement $requirement,
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
        $isApproved = strtolower($this->status) === 'approved';

        $status = ucfirst(
            strtolower($this->status)
        );

        return [
            'type' => 'onboard_requirement_status',

            'title' => $isApproved
                ? 'Onboard Requirement Approved'
                : 'Onboard Requirement Rejected',

            'message' =>
                'Your onboard requirement "' .
                ($this->requirement->title ?? 'Requirement') .
                '" has been ' .
                strtolower($status) .
                (
                    $this->remarks
                        ? '. Remarks: ' . $this->remarks
                        : '.'
                ),

            'cadet_id' => $this->cadet->id,

            'requirement_id' => $this->requirement->id,

            'status' => $status,

            'remarks' => $this->remarks,

            /*
             * Send the cadet directly to
             * the Onboard Requirements page.
             */
            'url' => route('cadet.onboard.requirements'),

            'icon' => $isApproved
                ? 'fa-circle-check'
                : 'fa-circle-xmark',

            'color' => $isApproved
                ? 'green'
                : 'red',
        ];
    }

    /**
     * Realtime broadcast notification.
     */
    public function toBroadcast(User $notifiable): BroadcastMessage
    {
        return new BroadcastMessage(
            $this->toDatabase($notifiable)
        );
    }
}