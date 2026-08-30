<?php

namespace App\Notifications;

use App\Models\Cadet;
use App\Models\OnboardRequirement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CadetRequirementSubmitted extends Notification
{
    use Queueable;

    public function __construct(
        public Cadet $cadet,
        public OnboardRequirement $requirement
    ) {
    }


    // =========================================================
    // CHANNELS
    // =========================================================

    public function via($notifiable): array
    {
        return [
            'database',
            'broadcast',
        ];
    }


    // =========================================================
    // DATABASE
    // =========================================================

    public function toDatabase($notifiable): array
    {
        return [
            'type' =>
                'cadet_requirement_submitted',

            'title' =>
                'New Requirement Submitted',

            'message' =>
                ($this->cadet->full_name ?? 'A cadet')
                . ' submitted "'
                . ($this->requirement->title ?? 'a requirement')
                . '"',

            'icon' =>
                'fa-file-circle-check',

            'color' =>
                'blue',

            'url' =>
                route(
                    'admin.cadet.requirements.index'
                ),

            'cadet_id' =>
                $this->cadet->id,

            'requirement_id' =>
                $this->requirement->id,

            'requirement_title' =>
                $this->requirement->title,
        ];
    }


    // =========================================================
    // REALTIME BROADCAST
    // =========================================================

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage(
            [
                'type' =>
                    'cadet_requirement_submitted',

                'title' =>
                    'New Requirement Submitted',

                'message' =>
                    ($this->cadet->full_name ?? 'A cadet')
                    . ' submitted "'
                    . ($this->requirement->title ?? 'a requirement')
                    . '"',

                'icon' =>
                    'fa-file-circle-check',

                'color' =>
                    'blue',

                'url' =>
                    route(
                        'admin.cadet.requirements.index'
                    ),

                'cadet_id' =>
                    $this->cadet->id,

                'requirement_id' =>
                    $this->requirement->id,

                'requirement_title' =>
                    $this->requirement->title,
            ]
        );
    }


    // =========================================================
    // BROADCAST TYPE
    // =========================================================

    public function broadcastType(): string
    {
        return 'cadet.requirement.submitted';
    }
}