<?php

namespace App\Mail;

use App\Models\ClaimPark;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClaimParkConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $claimPark;

    /**
     * Create a new message instance.
     */
    public function __construct(ClaimPark $claimPark)
    {
        $this->claimPark = $claimPark;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Claim Park Confirmation Mail')
            ->view('emails.claim_park_confirmation');
    }
}
