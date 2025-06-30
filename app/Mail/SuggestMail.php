<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuggestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $suggestedPark;

    /**
     * Create a new message instance.
     */
    public function __construct($suggestedPark)
    {
        $this->suggestedPark = $suggestedPark;
    }

    public function build()
    {
        return $this->subject('New Suggestion Park')
            ->view('emails.suggest-park');
    }
}
