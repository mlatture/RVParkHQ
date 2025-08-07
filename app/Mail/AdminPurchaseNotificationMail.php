<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Bill;
use App\Models\User;

class AdminPurchaseNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $bill;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Bill $bill)
    {
        $this->user = $user;
        $this->bill = $bill;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Purchase Notification')
            ->view('emails.admin-purchase-notification')
            ->with([
                'user' => $this->user,
                'bill' => $this->bill,
            ]);
    }
} 