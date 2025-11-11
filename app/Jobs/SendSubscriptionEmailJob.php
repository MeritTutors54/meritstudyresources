<?php

namespace App\Jobs;

use App\Enums\EmailType;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSubscriptionEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected mixed $user;
    protected mixed $pdf;
    protected int $type;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $pdf = null, int $type = 0)
    {
        $this->user = $user;
        $this->pdf = $pdf;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->type == EmailType::NEW_SUBSCRIPTION->value) {
            \Mail::to($this->user->email)->send(new \App\Mail\SubscriptionInvoiceMail($this->user, $this->pdf));
        } else if($this->type == EmailType::RENEW_SUBSCRIBER->value) {
            \Mail::to($this->user->email)->send(new \App\Mail\SubscriptionInvoiceMail($this->user, $this->pdf));
        }
    }
}
