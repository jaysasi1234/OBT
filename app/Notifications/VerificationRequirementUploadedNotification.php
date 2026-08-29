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
     * Database notification.
     */
    public function toDatabase($notifiable): array
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
     * Realtime broadcast notification.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
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
        ]);
    }
}