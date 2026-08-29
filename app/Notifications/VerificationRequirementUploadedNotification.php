<?php

namespace App\Notifications;

use App\Models\Cadet;
use App\Models\Document;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class VerificationRequirementUploadedNotification extends Notification
{
    public function __construct(
        public Cadet $cadet,
        public Document $document
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
     * Notification data.
     */
    protected function notificationData(): array
    {
        return [
            'type' => 'verification_requirement_uploaded',

            'title' => 'New Verification Requirement',

            'message' =>
                ($this->cadet->full_name ?? 'A cadet') .
                ' submitted ' .
                ($this->document->name ?? 'a document') .
                ' for verification.',

            'cadet_id' => $this->cadet->id,

            'document_id' => $this->document->id,

            'document_name' => $this->document->name,

            'url' => route(
                'admin.verification.show',
                $this->cadet->id
            ),

            'icon' => 'fa-file-circle-check',

            'color' => 'blue',
        ];
    }

    /**
     * Save notification in database.
     */
    public function toDatabase($notifiable): array
    {
        return $this->notificationData();
    }

    /**
     * Broadcast notification in realtime.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage(
            $this->notificationData()
        );
    }

    /**
     * Array representation.
     */
    public function toArray($notifiable): array
    {
        return $this->notificationData();
    }
}
