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
        $pending = Review::where('token', $token)->firstOrFail();

        $alreadyExists = Review::where([
            'email' => $pending->email,
            'park_id' => $pending->park_id,
            'status' => 'confirmed',
        ])->exists();

        if ($alreadyExists) {
            return 'already_submitted';
        }

        $pending->update([
            'status' => 'confirmed',
        ]);

        return 'confirmed';
    }
}
