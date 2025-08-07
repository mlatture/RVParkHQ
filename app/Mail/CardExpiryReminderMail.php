<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Card;

class CardExpiryReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $card;

    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    public function build()
    {
        return $this->subject('Card Expiry Reminder')
            ->view('emails.card-expiry-reminder')
            ->with(['card' => $this->card]);
    }
} 