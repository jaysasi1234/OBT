<?php

namespace App\Events;

use App\Models\CadetBSRequirement;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class BSRequirementUploaded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CadetBSRequirement $submission;

    public function __construct(CadetBSRequirement $submission)
    {
        $this->submission = $submission->load([
            'cadet',
            'requirement'
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('bs-requirements');
    }

    public function broadcastAs()
    {
        return 'BSRequirementUploaded';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->submission->id,
            'cadet' => $this->submission->cadet->full_name,
            'requirement' => $this->submission->requirement->title,
            'status' => $this->submission->status,
            'submitted_at' => $this->submission->submitted_at,
        ];
    }
}