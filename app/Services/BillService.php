<?php

namespace App\Services;

use App\Models\Bill;
use Illuminate\Support\Facades\Mail;

class BillService
{
    public function getBillsWithFilter(?string $search)
    {
        return Bill::with('user')
            ->filter($search)
            ->latest()
            ->paginate(10);
    }

    public function createBill(array $data, bool $sendNow = false): Bill
    {
        $data['payment_link_token'] = $data['payment_link_token'] ?? \Illuminate\Support\Str::random(40);
        $bill = Bill::create([
            'send_from' => $data['send_from'],
            'sales_rep' => $data['sales_rep'],
            'subject' => $data['subject'],
            'description' => $data['description'],
            'schedule' => $data['schedule'],
            'due_date' => $data['due_date'],
            'amount' => $data['amount'],
            'user_id' => $data['user_id'],
            'payment_link_token' => $data['payment_link_token'],
            'status' => 'pending',
            'billing_recipient' => $data['bill_rep'],
        ]);

        if ($sendNow) {
            Mail::to($bill->user->email)->send(new \App\Mail\BillMail($bill));
        }

        return $bill;
    }

    public function updateBill(Bill $bill, array $data, bool $sendNow = false): Bill
    {
        if (empty($bill->payment_link_token)) {
            $data['payment_link_token'] = \Illuminate\Support\Str::random(40);
        }
        $bill->update([
            'send_from' => $data['send_from'],
            'sales_rep' => $data['sales_rep'],
            'subject' => $data['subject'],
            'description' => $data['description'],
            'schedule' => $data['schedule'],
            'due_date' => $data['due_date'],
            'amount' => $data['amount'],
            'user_id' => $data['user_id'],
            'payment_link_token' => $data['payment_link_token'] ?? $bill->payment_link_token,
            'billing_recipient' => $data['bill_rep'],
        ]);

        if ($sendNow) {
            Mail::to($bill->user->email)->send(new \App\Mail\BillMail($bill));
        }

        return $bill;
    }
}
