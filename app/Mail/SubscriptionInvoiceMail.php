<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public mixed $user;
    public mixed $invoicePdf;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $invoicePdf)
    {
        $this->user = $user;
        $this->invoicePdf = $invoicePdf;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Invoice Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.invoice',
            with: [
                'home_link' => route('home'),
                'invoicePdf' => $this->invoicePdf,
                'user' => $this->user,
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
