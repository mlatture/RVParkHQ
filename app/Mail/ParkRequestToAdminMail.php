<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ParkRequestToAdminMail extends Mailable
{
    public $user;
    public $park;

    public function __construct($user, $park)
    {
        $this->user = $user;
        $this->park = $park;
    }

    public function build()
    {
        return $this->subject('New Park Request')
            ->view('emails.park_request_to_admin');
    }
} 