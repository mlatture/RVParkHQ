<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use App\Models\Card;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    public function showPaymentForm($token)
    {
        $bill = Bill::where('payment_link_token', $token)->firstOrFail();
        $bill->load('user');

        if (!auth()->check()) {
            Auth::login($bill->user);
        } elseif (auth()->id() !== $bill->user->id) {
            Auth::logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            Auth::login($bill->user);
        }

        $user = auth()->user();
        $cards = Card::where('user_id', $user->id)->get();

        return view('frontend.pages.payment.pay-bill', compact('bill', 'cards'));
    }

    public function processPayment(Request $request, $token)
    {
        try {
            $bill = \App\Models\Bill::where('payment_link_token', $token)->firstOrFail();
            $bill->load('user');
            $user = $bill->user;

            $request->validate([
                'card_option' => 'required',
            ]);

            $card = null;
            if ($request->card_option === 'new') {
                $request->validate([
                    'card_number' => 'required|digits:16',
                    'expiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
                    'cvc' => 'required|digits_between:3,4',
                ]);
                $card = Card::create([
                    'user_id' => $user->id,
                    'card_number' => substr($request->card_number, -4),
                    'expiry' => $request->expiry,
                    'cvc' => $request->cvc,
                ]);
            } else {
                $card = Card::findOrFail($request->card_option);
            }

            $service = new PaymentService();
            $result = $service->processCardknoxPayment($user, $bill, $card, $bill->amount, false);
            if ($result['success']) {
                $bill->status = 'paid';
                $bill->payment_link_token = null;
                $bill->save();
                return redirect()->route('rv-park.profile.bill')->with([
                    'icon' => 'success',
                    'success' => 'Payment successful!'
                ]);
            } else {
                return back()->with([
                    'icon' => 'error',
                    'error' => 'Payment failed: ' . ($result['error'] ?? 'Unknown error')
                ])->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return back()->with([
                'icon' => 'error',
                'error' => 'An error occurred while processing the payment: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function showCardPaymentFormCard($id)
    {
        $payment_id = decrypt($id);
        $payment = Payment::where('id', $payment_id)->firstOrFail();
        $payment->load('bill');

        if ($payment->status == "success")
        {
            return back()->with([
                'icon' => 'info',
                'success' => 'The amount has already been paid.',
            ]);
        }
//        if (!auth()->check()) {
//            Auth::login($payment->user);
//        } elseif (auth()->id() !== $payment->user_id) {
//            Auth::logout();
//            request()->session()->invalidate();
//            request()->session()->regenerateToken();
//            Auth::login($payment->user);
//        }

        $user = auth()->user();
        $cards = Card::where('user_id', $user->id)->get();

        return view('frontend.pages.payment.pay-bill-card', [
            'payment' => $payment,
            'bill' => $payment->bill,
            'cards' => $cards,
        ]);
    }

    public function processCardPayment(Request $request, $id)
    {

        try {
            $payment = Payment::where('id', $id)->firstOrFail();
            $payment->load('bill');
            $user = $payment->user;

            $request->validate([
                'card_option' => 'required',
            ]);

            $card = null;
            if ($request->card_option === 'new') {
                $request->validate([
                    'card_number' => 'required|digits:16',
                    'expiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
                    'cvc' => 'required|digits_between:3,4',
                ]);
                $card = Card::create([
                    'user_id' => $user->id,
                    'card_number' => substr($request->card_number, -4),
                    'expiry' => $request->expiry,
                    'cvc' => $request->cvc,
                ]);
            } else {
                $card = Card::findOrFail($request->card_option);
            }

            $service = new PaymentService();
            $result = $service->processCardknoxPayment($user, $payment->bill, $card, $payment->amount, false, $payment);
            if ($result['success']) {
                \Log::debug('Redirecting after payment success', ['payment_id' => $payment->id]);
                return redirect()->route('rv-park.profile.bill')->with([
                    'icon' => 'success',
                    'success' => 'Payment successful!'
                ]);
            } else {
                return back()->with([
                    'icon' => 'error',
                    'success' => 'Payment failed: ' . ($result['error'] ?? 'Unknown error')
                ])->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Payment Validation Exception:', ['error' => $e->getMessage()]);
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Payment Exception:', ['error' => $e->getMessage()]);
            return back()->with([
                'icon' => 'error',
                'success' => 'An error occurred while processing the payment: ' . $e->getMessage()
            ])->withInput();
        }
    }
}
