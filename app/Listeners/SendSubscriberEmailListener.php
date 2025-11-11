<?php

namespace App\Listeners;

use App\Enums\EmailType;
use App\Mail\CancelSubscriptionMail;
use App\Mail\NewSubscriptionMail;
use App\Mail\PauseSubscriptionMail;
use App\Mail\RenewSubscriptionMail;
use App\Mail\ResumeSubscriptionMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendSubscriberEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $email = $event->email;
        $type = $event->type;
        $data = $event->data;

        if ($type === EmailType::NEW_SUBSCRIPTION->value) {
            Mail::to($email)->send(new NewSubscriptionMail("You're in! Thanks for subscribing", $data));
        } elseif ($type === EmailType::PAUSE_SUBSCRIBER->value) {
            Mail::to($email)->send(new PauseSubscriptionMail());
        } elseif ($type === EmailType::RESUME_SUBSCRIBER->value) {
            Mail::to($email)->send(new ResumeSubscriptionMail());
        } elseif ($type === EmailType::CANCEL_SUBSCRIBER->value) {
            Mail::to($email)->send(new CancelSubscriptionMail());
        } elseif ($type === EmailType::RENEW_SUBSCRIBER->value) {
            Mail::to($email)->send(new RenewSubscriptionMail('Thank You for Renewing!', $data));
        }
    }
}
