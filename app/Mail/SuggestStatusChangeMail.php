<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuggestStatusChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $park;
    public $status;

    /**
     * Create a new message instance.
     */
    public function __construct($park, $status)
    {
        $this->park = $park;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('Your Suggest Park Status')
            ->view('emails.suggest-park-status-change');
    }
}
