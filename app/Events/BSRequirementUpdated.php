<?php

namespace App\Events;

use App\Models\CadetBSRequirement;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BSRequirementUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CadetBSRequirement $submission;

    public function __construct(CadetBSRequirement $submission)
    {
        $this->submission = $submission;
    }

    public function broadcastOn()
    {
        return new Channel('bs-requirements');
    }

    public function broadcastAs()
    {
        return 'BSRequirementUpdated';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->submission->id,
            'status' => $this->submission->status,
        ];
    }
}