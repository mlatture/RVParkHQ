<?php

namespace App\Services\Frontend;

use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewConfirmationMail;

class ReviewService
{
    public function storePendingReview(array $data)
    {
        $data['ip_address'] = request()->ip();
        $data['token'] = Str::uuid()->toString();
        
        $pending = Review::create($data);
        $pending->load('park');

        Mail::to($pending->email)->send(new ReviewConfirmationMail($pending));

        return $pending;
    }

    public function confirmReview(string $token): string
{
    // Only consider pending rows for this token (prevents reuse if you keep old rows)
    $pending = Review::where([
        'token'  => $token,
        'status' => 'pending',      // <- if you track status
    ])->first();

    if (!$pending) {
        // The token might have been used already or never existed
        // Try to tell if it's already confirmed to return a nicer message
        $already = Review::where('token', $token)->where('status', 'confirmed')->exists();
        return $already ? 'already_confirmed' : 'invalid';
    }

    // Optional: enforce expiry if you have a column like token_expires_at
    if (!empty($pending->token_expires_at) && now()->greaterThan($pending->token_expires_at)) {
        return 'expired';
    }

    // If there’s already a confirmed review by this email for this park, don’t double-submit
    $alreadyExists = Review::where([
        'email'   => $pending->email,
        'park_id' => $pending->park_id,
        'status'  => 'confirmed',
    ])->exists();

    if ($alreadyExists) {
        return 'already_submitted';
    }

    // Mark single-use and finalize
    $pending->forceFill([
        'status'            => 'confirmed',
        'confirmed_at'      => now(),       // <- add this column if you have it
        'token'             => null,        // <- clears token so link can never be reused
        'token_used_at'     => now(),       // <- optional audit column
        'token_expires_at'  => null,        // <- optional: clear expiry
    ])->save();

    return 'confirmed';
}

}
