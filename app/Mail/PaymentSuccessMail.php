<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Bill;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bill;

    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }

    public function build()
    {
        return $this->subject('Payment Successful')
            ->view('emails.payment-success')
            ->with(['bill' => $this->bill]);
    }
} 