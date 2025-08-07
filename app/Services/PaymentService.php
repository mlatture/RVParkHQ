<?php

namespace App\Services;

use App\Models\Payment;
use App\Mail\PaymentSuccessMail;
use App\Mail\PaymentFailedMail;
use App\Mail\AdminPurchaseNotificationMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PaymentService
{
    public function processCardknoxPayment($user, $bill, $card, $amount, $isRecurring = false, $payment = null)
    {
        // Use token for recurring, card details for one-time
        if ($isRecurring && $card->cardknox_token) {
            $payload = [
                'xKey' => env('CARDKNOX_API_KEY'),
                'xVersion' => '4.5.6',
                'xCommand' => 'cc:sale',
                'xAmount' => $amount,
                'xToken' => $card->cardknox_token,
                'xName' => $user->name ?? 'Customer',
            ];
        } else {
            $payload = [
//                'xKey' => env('CARDKNOX_API_KEY'),
                'xKey' => config('services.cardknox.key'),
                'xSoftwareVersion' => '1.0.0',
                'xVersion' => '4.5.6',
                'xSoftwareName' => config('app.name'),
                'xCommand' => 'cc:sale',
                'xAmount' => $amount,
                'xCardNum' => $card->card_number,
                'xExp' => str_replace('/', '', $card->expiry),
                'xCVV' => $card->cvc,
                'xName' => $user->name ?? 'Customer',
                'xInvoice' => 'RECUR-' . uniqid() . '-' . now()->format('YmdHis'),
            ];
        }

        $response = Http::asForm()->post('https://x1.cardknox.com/gateway', $payload);
        $responseString = $response->body();

        parse_str($responseString, $data);
        //logger($response, $data);
        if (isset($data['xResult']) && $data['xResult'] === 'A') {
            if ($payment) {
                $payment->amount = $amount;
                $payment->payment_method = 'credit_card';
                $payment->processed_at = now();
                $payment->status = 'success';
                $payment->card_id = $card->id;
                $payment->save();
            } else {
                $payment = Payment::create([
                    'bill_id' => $bill->id,
                    'user_id' => $user->id,
                    'card_id' => $card->id,
                    'amount' => $amount,
                    'payment_method' => 'credit_card',
                    'processed_at' => now(),
                    'status' => 'success',
                ]);
            }

            $this->sendPaymentEmails($user, $bill, true);

            return ['success' => true, 'payment' => $payment];
        }

        elseif (isset($data['xErrorCode']) && $data['xErrorCode'] === '01332') {

            $payment = Payment::create([
                'bill_id' => $bill->id,
                'user_id' => $user->id,
                'card_id' => $card->id ?? null,
                'amount' => $amount,
                'payment_method' => 'credit_card',
                'processed_at' => now(),
                'status' => 'duplicate',
            ]);

            return [
                'success' => false,
                'payment' => $payment,
                'error' => 'Duplicate transaction. This payment may have already been processed.'
            ];
        }

        else {
            $payment = Payment::create([
                'bill_id' => $bill->id,
                'user_id' => $user->id,
                'card_id' => $card->id,
                'amount' => $amount,
                'payment_method' => 'credit_card',
                'processed_at' => now(),
                'status' => 'failed',
            ]);

            $this->sendPaymentEmails($user, $bill, false, $data['xError'] ?? $data['xResultText'] ?? 'Unknown error');

            return [
                'success' => false,
                'payment' => $payment,
                'error' => $data['xError'] ?? $data['xResultText'] ?? 'Unknown error'
            ];
        }
    }

    public function sendPaymentEmails($user, $bill, $success, $errorMsg = null)
    {
        \Log::debug('sendPaymentEmails called', [
            'user' => $user,
            'bill' => $bill,
            'bill_user' => $bill?->user
        ]);
        if (!$user && $bill && $bill->user) {
            $user = $bill->user;
        }
        if (!$user) {
            \Log::error('No user found for sending payment email.');
            return;
        }
        
        // Determine email recipient: billing_recipient if not null, otherwise user email
        $emailRecipient = null;
        if ($bill->billing_recipient && filter_var($bill->billing_recipient, FILTER_VALIDATE_EMAIL)) {
            $emailRecipient = $bill->billing_recipient;
        } else {
            $emailRecipient = $user->email;
        }
        
        if ($success) {
            Mail::to($emailRecipient)->send(new PaymentSuccessMail($bill));
            // Admin ko bhi email bhejo
            $adminEmail = config('mail.notification_email');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new \App\Mail\AdminPurchaseNotificationMail($user, $bill));
            }
            // Sales rep ko bhi email bhejo agar valid email hai
            if (filter_var($bill->sales_rep, FILTER_VALIDATE_EMAIL)) {
                Mail::to($bill->sales_rep)->send(new \App\Mail\AdminPurchaseNotificationMail($user, $bill));
            }
        } else {
            Mail::to($emailRecipient)->send(new PaymentFailedMail($bill, $errorMsg));
        }
    }
}
