<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ParkRequestStatusToOwnerMail extends Mailable
{
    public $owner;
    public $park;
    public $status;

    public function __construct($owner, $park, $status)
    {
        $this->owner = $owner;
        $this->park = $park;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('Your Park Request Status')
            ->view('emails.park_request_status_to_owner');
    }
} 