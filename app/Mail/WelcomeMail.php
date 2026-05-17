<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public $user,
        public string $intent = 'attendee'
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to EventOga',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
            with: [
                'user' => $this->user,
                'intent' => $this->intent,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
