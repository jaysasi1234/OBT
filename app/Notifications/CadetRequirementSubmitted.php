<?php

namespace App\Notifications;

use App\Models\Cadet;
use App\Models\OnboardRequirement;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class CadetRequirementSubmitted extends Notification
{
    public function __construct(
        public Cadet $cadet,
        public OnboardRequirement $requirement
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
        return [
            'type' => 'onboard_requirement_submitted',

            'title' => 'New Requirement Submitted',

            'message' =>
                ($this->cadet->full_name ?? 'A cadet')
                . ' submitted "'
                . ($this->requirement->title ?? 'an onboard requirement')
                . '"',

            'icon' => 'fa-file-circle-check',

            'url' => route(
                'admin.cadet.requirements.index'
            ),

            'cadet_id' => $this->cadet->id,

            'requirement_id' => $this->requirement->id,

            'requirement_title' => $this->requirement->title,

            'color' => 'blue',
        ];
    }

    /**
     * Realtime broadcast notification.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'onboard_requirement_submitted',

            'title' => 'New Requirement Submitted',

            'message' =>
                ($this->cadet->full_name ?? 'A cadet')
                . ' submitted "'
                . ($this->requirement->title ?? 'an onboard requirement')
                . '"',

            'icon' => 'fa-file-circle-check',

            'url' => route(
                'admin.cadet.requirements.index'
            ),

            'cadet_id' => $this->cadet->id,

            'requirement_id' => $this->requirement->id,

            'requirement_title' => $this->requirement->title,

            'color' => 'blue',
        ]);
    }

    /**
     * Array representation.
     */
    public function toArray($notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
