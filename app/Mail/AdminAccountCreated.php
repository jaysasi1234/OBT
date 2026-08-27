<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public string $token;

    public function __construct(
        User $user,
        string $token
    ) {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        $subject = $this->user->role === 'dean'
            ? 'Your Dean Account Has Been Created'
            : 'Your Administrator Account Has Been Created';

        return $this
            ->subject($subject)
            ->view('emails.admin-account-created');
    }
}