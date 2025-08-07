<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function bill()
    {
        $user = auth()->user();
        $bills = $user->bills()->orderByDesc('created_at')->get();
        return view('frontend.pages.profile.bill.index', compact('bills'));
    }

    public function paymentHistory($id)
    {
        $user = auth()->user();
        $bill_id = decrypt($id);
        $payment_history = Payment::where([
            'bill_id' => $bill_id,
            'user_id' => $user->id
        ])->with('bill')->get();

        return view('frontend.pages.profile.bill.payments', compact('payment_history'));
    }
}
