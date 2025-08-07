<?php

namespace App\Services\Frontend;

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

        $pending = Subscriber::where('email', $email)->first();
        if ($pending) {
            Mail::to($email)->send(new ConfirmSubscriptionMail($pending->token));
            return ['status' => true, 'message' => 'Confirmation email resent. Please check your inbox.', 'type' => 'success'];
        }

        $token = Str::uuid();
        Subscriber::create([
            'email' => $email,
            'token' => $token,
        ]);

        Mail::to($email)->send(new ConfirmSubscriptionMail($token));

        return ['status' => true, 'message' => 'Confirmation email sent. Please check your inbox.', 'type' => 'success'];
    }

    public function handleConfirmation($data)
    {

        $pending = Subscriber::where('token', $data['token'])->first();

        if (!$pending) {
            return ['message' => 'Invalid or expired confirmation link.', 'type' => 'error'];
        }

        $pending->update([
            'name' => $data['name'],
            'zip_code' => $data['zip_code'],
            'status' => 'subscribe',
            'confirmed_at' => now()->toDateString(),
            'token' => null,
        ]);

        return ['message' => 'Subscription confirmed successfully!', 'type' => 'success'];
    }
}
