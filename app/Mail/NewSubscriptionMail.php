<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = '';
    public array|null $data = null;
    /**
     * Create a new message instance.
     */

    public function __construct(string $subject, array $data = null)
    {
        $this->subject = $subject;
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.new_subscription_mail',
            with: [
                'home_link' => route('home'),
                'dashboard_link' => route('user.dashboard'),
                'data' => $this->data,
            ]
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
