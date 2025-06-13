<?php

namespace App\Services\Frontend;

use App\Models\Review;
use App\Models\PendingReviews;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewConfirmationMail;
use App\Models\Park;

class ReviewService
{
    public function getFilteredParks(array $filters, int $perPage = 12): array
    {
        $parks = Park::query()
            ->filter($filters)
            ->paginate($perPage)
            ->withQueryString();

        $states = Park::select('state')
            ->distinct()
            ->orderBy('state')
            ->get();

        return [
            'parks' => $parks,
            'states' => $states,
        ];
    }

    public function getParkDetails($encryptedId)
    {
        $park = Park::findOrFail(decrypt($encryptedId));
        $reviews = Review::latest()->limit(10)->get();

        return compact('park', 'reviews');
    }

    public function storePendingReview(array $data): PendingReviews
    {
        $data['ip_address'] = request()->ip();
        $data['token'] = Str::uuid()->toString();

        $pending = PendingReviews::create($data);
        $pending->load('park');

        Mail::to($pending->email)->send(new ReviewConfirmationMail($pending));

        return $pending;
    }

    public function confirmReview(string $token): string
    {
        $pending = PendingReviews::where('token', $token)->firstOrFail();

        $alreadyExists = Review::where([
            'email' => $pending->email,
            'park_id' => $pending->park_id,
        ])->exists();

        if ($alreadyExists) {
            return 'already_submitted';
        }

        Review::create([
            'park_id' => $pending->park_id,
            'rating' => $pending->rating,
            'name' => $pending->name,
            'email' => $pending->email,
            'message' => $pending->message,
            'ip_address' => $pending->ip_address,
        ]);

        // $pending->delete();

        return 'confirmed';
    }
}
