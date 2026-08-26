<?php

namespace App\Notifications;

use App\Models\CadetBSRequirement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BSRequirementUploadedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public CadetBSRequirement $submission)
    {
        $this->submission->load([
            'cadet',
            'requirement',
        ]);
    }

    /**
     * Notification channels.
     */
    public function via($notifiable)
    {
        return [
            'database',
            'broadcast',
        ];
    }

    /**
     * Database notification payload.
     */
    public function toArray($notifiable)
    {
        return [

            'title' => 'New BS Requirement',

            'icon' => 'fa-graduation-cap',

            'message' =>
                $this->submission->cadet->full_name .
                ' uploaded ' .
                $this->submission->requirement->title,

            'submission_id' =>
                $this->submission->id,

            'cadet_id' =>
                $this->submission->cadet_id,

            'status' =>
                $this->submission->status,

            'url' =>
                route('admin.cadet.bs.index'),

        ];
    }
}