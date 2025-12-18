<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MagicLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $magicLink;
    public $userType;
    public $loginUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($magicLink, $userType)
    {
        $this->magicLink = $magicLink;
        $this->userType = $userType;
        $this->loginUrl = url("/{$userType}/login/magic/{$magicLink->token}");
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->userType === 'talent' 
            ? 'Đăng nhập nhanh vào Vietlance Talent' 
            : 'Đăng nhập nhanh vào Vietlance Client';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.magic-link',
            with: [
                'magicLink' => $this->magicLink,
                'userType' => $this->userType,
                'loginUrl' => $this->loginUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

