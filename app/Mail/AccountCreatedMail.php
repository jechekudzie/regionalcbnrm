<?php

namespace App\Mail;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $user;
    public $userOrganisation;
    public function __construct($userId,$organisationId)
    {
        $this->user = User::find($userId);
        $this->userOrganisation = Organisation::find($organisationId);
    }

    public function build()
    {
        return $this->markdown('mails.mail')
            ->subject('Account Created');
    }
    public function attachments(): array
    {
        return [];
    }
}
