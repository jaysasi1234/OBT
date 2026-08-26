<?php

namespace App\Notifications;

use App\Models\Cadet;
use App\Models\OnboardRequirement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class CadetRequirementSubmitted extends Notification
{
    use Queueable;

    protected Cadet $cadet;
    protected OnboardRequirement $requirement;

    public function __construct(Cadet $cadet, OnboardRequirement $requirement)
    {
        $this->cadet = $cadet;
        $this->requirement = $requirement;
    }

public function via($notifiable)
{
    return [
        'database',
        'broadcast'
    ];
}

public function toArray($notifiable)
{
    return [
        'title' => 'New Requirement Submitted',

        'message' => $this->cadet->full_name .
            ' submitted "' .
            $this->requirement->title . '"',

        'icon' => '📄',

        'url' => route('admin.cadet.requirements.index'),

        'cadet_id' => $this->cadet->id,
    ];
}

public function toBroadcast($notifiable)
{
    return new BroadcastMessage([
        'title' => 'New Requirement Submitted',

        'message' => $this->cadet->full_name .
            ' submitted "' .
            $this->requirement->title . '"',

        'icon' => '📄',

        'url' => route('admin.cadet.requirements.index'),

        'cadet_id' => $this->cadet->id,
    ]);
}
}