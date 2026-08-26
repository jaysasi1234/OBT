<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CadetLocationUpdated implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public int $cadetId,
        public string $fullName,
        public ?string $trbControlNumber,
        public ?string $course,
        public ?float $latitude,
        public ?float $longitude,
        public ?string $lastSeen,
        public string $onlineStatus,
        public ?string $photo = null
    ) {
    }

    /**
     * Broadcast channel.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(
                'admin.cadet-locations'
            ),
        ];
    }

    /**
     * Event name used by Echo.
     */
    public function broadcastAs(): string
    {
        return 'cadet.location.updated';
    }

    /**
     * Payload sent to the browser.
     */
    public function broadcastWith(): array
    {
        return [
            'cadet_id' => $this->cadetId,

            'full_name' => $this->fullName,

            'trb_control_number' =>
                $this->trbControlNumber,

            'course' =>
                $this->course,

            'latitude' =>
                $this->latitude,

            'longitude' =>
                $this->longitude,

            'last_seen' =>
                $this->lastSeen,

            'online_status' =>
                $this->onlineStatus,

            'photo' =>
                $this->photo,
        ];
    }
}