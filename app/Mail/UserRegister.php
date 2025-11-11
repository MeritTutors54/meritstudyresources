<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegister extends Mailable
{
    use Queueable, SerializesModels;

    protected string $code;
    protected string $base_url;
    public function __construct($code, $base_url)
    {
        $this->code = $code;
        $this->base_url = $base_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $code = $this->code;
        $url = $this->base_url . "/verification?token=$code";

        return $this->view('mail.user_register_mail', compact('code','url'));
    }
}
