<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bill;
use App\Models\Card;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccessMail;
use App\Mail\PaymentFailedMail;
use App\Mail\CardExpiryReminderMail;
use App\Mail\AdminPurchaseNotificationMail;
use App\Services\PaymentService;

class ProcessRecurringBills extends Command
{
    protected $signature = 'bills:process-recurring';
    protected $description = 'Process recurring monthly/yearly bills and charge users automatically';

    public function handle()
    {
        $today = Carbon::today();

        $bills = Bill::whereIn('schedule', ['monthly', 'yearly'])
            ->with(['latestPayment', 'user'])
            ->whereDate('due_date', '<=', $today)
            ->get();

        $service = new PaymentService();
        foreach ($bills as $bill) {
            $user = $bill->user;
            $card = $user->cards()->first();

            $schedule = $bill->getAttributes()['schedule'];
            $lastPayment = $bill->latestPayment;
            $now = now();

            // Ignore bills with no successful payment ever
            if (!$lastPayment || $lastPayment->status !== 'success') {
                continue;
            }

            // Anniversary logic
            $shouldPay = false;
            if ($schedule == 'monthly') {
                if ($now->greaterThanOrEqualTo(\Carbon\Carbon::parse($lastPayment->processed_at)->addMonth())) {
                    $shouldPay = true;
                }
            } elseif ($schedule == 'yearly') {
                if ($now->greaterThanOrEqualTo(\Carbon\Carbon::parse($lastPayment->processed_at)->addYear())) {
                    $shouldPay = true;
                }
            }

            // Prevent duplicate payment on same day
            $alreadyPaidToday = Payment::where('bill_id', $bill->id)
                ->where('status', 'success')
                ->whereDate('processed_at', $now->toDateString())
                ->exists();

            if (!$shouldPay || $alreadyPaidToday) {
                continue;
            }

            // --- Card check and payment creation ---
            if (!$card) {
                // No card: create failed payment
                Payment::create([
                    'bill_id' => $bill->id,
                    'user_id' => $user->id,
                    'card_id' => null,
                    'amount' => $bill->amount,
                    'payment_method' => 'credit_card',
                    'processed_at' => now(),
                    'status' => 'failed',
                ]);
                Mail::to($user->email)->send(new PaymentFailedMail($bill));
                continue;
            }

            // Card exists: use PaymentService for recurring payment
            $result = $service->processCardknoxPayment($user, $bill, $card, $bill->amount, true);
            if ($result['success']) {
                if ($schedule == 'monthly') {
                    $bill->due_date = \Carbon\Carbon::parse($bill->due_date)->addMonth();
                } elseif ($schedule == 'yearly') {
                    $bill->due_date = \Carbon\Carbon::parse($bill->due_date)->addYear();
                }
                $bill->status = 'paid';
                $bill->save();
                $this->info("Processed recurring payment for Bill ID {$bill->id}");
            }
        }

        $reminderDate = Carbon::today()->addDays(3)->format('Y-m');
        $cards = \App\Models\Card::where('expiry', $reminderDate)->get();
        foreach ($cards as $card) {
            Mail::to($card->user->email)->send(new CardExpiryReminderMail($card));
            $this->info("Sent card expiry reminder to user ID {$card->user_id} for card ending " . substr($card->card_number, -4));
        }
    }
}
