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
        $bill = Bill::create([
            'send_from' => $data['send_from'],
            'sales_rep_id' => $data['sales_rep'],
            'subject' => $data['subject'],
            'description' => $data['description'],
            'schedule' => $data['schedule'],
            'due_date' => $data['due_date'],
            'amount' => $data['amount'],
            'customer_id' => $data['customer_id'],
            'status' => $sendNow ? 'sent' : 'draft',
        ]);

        if ($sendNow) {
            Mail::to($bill->user->email)->send(new \App\Mail\BillMail($bill));
        }

        return $bill;
    }

    public function updateBill(Bill $bill, array $data, bool $sendNow = false): Bill
    {
        $bill->update([
            'send_from' => $data['send_from'],
            'sales_rep_id' => $data['sales_rep'],
            'subject' => $data['subject'],
            'description' => $data['description'],
            'schedule' => $data['schedule'],
            'due_date' => $data['due_date'],
            'amount' => $data['amount'],
            'customer_id' => $data['customer_id'],
            'status' => $sendNow ? 'sent' : 'draft',
        ]);

        if ($sendNow) {
            Mail::to($bill->user->email)->send(new \App\Mail\BillMail($bill));
        }

        return $bill;
    }
}