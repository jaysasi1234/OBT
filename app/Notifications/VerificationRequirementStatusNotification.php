<?php

namespace App\Notifications;

use App\Models\Cadet;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class VerificationRequirementStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Cadet $cadet,
        public Document $document,
        public string $status,
        public ?string $remarks = null
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
        $isApproved = strtolower($this->status) === 'approved';

        return [
            'type' => 'verification_requirement_status',

            'title' => $isApproved
                ? 'Verification Requirement Approved'
                : 'Verification Requirement Rejected',

            'message' =>
                ($this->document->name ?? 'Verification requirement') .
                ' has been ' .
                strtolower($this->status) .
                ($this->remarks
                    ? '. Remarks: ' . $this->remarks
                    : '.'),

            'cadet_id' => $this->cadet->id,

            'document_id' => $this->document->id,

            'document_name' =>
                $this->document->name ?? 'Requirement',

            'status' => ucfirst(
                strtolower($this->status)
            ),

            'remarks' => $this->remarks,

            /*
             * Existing cadet page.
             */
            'url' => route('cadet.requirements'),

            'icon' => $isApproved
                ? 'fa-circle-check'
                : 'fa-circle-xmark',

            'color' => $isApproved
                ? 'green'
                : 'red',
        ];
    }


    /**
     * Realtime broadcast notification.
     */
    public function toBroadcast(User $notifiable): BroadcastMessage
    {
        return (new BroadcastMessage(
            $this->toDatabase($notifiable)
        ))
        ->onConnection('sync');
    }

}