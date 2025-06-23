<?php

namespace App\Services\Frontend;

use App\Models\PendingSubscriber;
use App\Models\Subscriber;
use App\Mail\ConfirmSubscriptionMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class SubscriberService
{
    public function handleStore($email)
    {
        if (Subscriber::where('email', $email)->exists()) {
            return ['status' => false, 'message' => 'You are already subscribed!', 'type' => 'info'];
        }

        $pending = PendingSubscriber::where('email', $email)->first();
        if ($pending) {
            Mail::to($email)->send(new ConfirmSubscriptionMail($pending->token));
            return ['status' => true, 'message' => 'Confirmation email resent. Please check your inbox.', 'type' => 'success'];
        }

        $token = Str::uuid();
        PendingSubscriber::create([
            'email' => $email,
            'token' => $token,
        ]);

        Mail::to($email)->send(new ConfirmSubscriptionMail($token));

        return ['status' => true, 'message' => 'Confirmation email sent. Please check your inbox.', 'type' => 'success'];
    }

    public function handleConfirmation($data)
    {
        if (Subscriber::where('email', $data['email'])->exists()) {
            return ['message' => 'You are already subscribed!', 'type' => 'info'];
        }

        $pending = PendingSubscriber::where('token', $data['token'])->first();

        if (!$pending) {
            return ['message' => 'Invalid or expired confirmation link.', 'type' => 'error'];
        }

        Subscriber::create([
            'email' => $pending->email,
            'name' => $data['name'],
            'zip_code' => $data['zip_code'],
            'confirmed_at' => Carbon::now(),
        ]);

        $pending->delete();

        return ['message' => 'Subscription confirmed successfully!', 'type' => 'success'];
    }
}
