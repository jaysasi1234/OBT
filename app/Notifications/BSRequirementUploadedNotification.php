<?php

namespace App\Notifications;

use App\Models\CadetBSRequirement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class BSRequirementUploadedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public CadetBSRequirement $submission
    ) {
        $this->submission->load([
            'cadet',
            'requirement',
        ]);
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
     * Notification data.
     */
    protected function notificationData(): array
    {
        return [

            'type' => 'bs_requirement_uploaded',

            'title' => 'New BS Requirement',

            'icon' => 'fa-graduation-cap',

            'color' => 'blue',

            'message' =>
                ($this->submission->cadet->full_name ?? 'A cadet') .
                ' uploaded ' .
                ($this->submission->requirement->title ?? 'a BS requirement'),

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

    /**
     * Database notification.
     */
    public function toDatabase($notifiable): array
    {
        return $this->notificationData();
    }

    /**
     * Realtime broadcast notification.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return (new BroadcastMessage(
            $this->notificationData()
        ))
        ->onConnection('sync');
    }

    /**
     * Array representation.
     */
    public function toArray($notifiable): array
    {
        return $this->notificationData();
    }
}