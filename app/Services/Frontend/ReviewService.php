<?php

namespace App\Services\Frontend;

use App\Models\Review;
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

    public function getParkDetails($country, $state, $city)
    {
        $park = Park::where('city', 'like', $city)
            ->orWhere('state', 'like', $state)
            ->orWhere('country', 'like', $country)->firstOrFail();
        $reviews = Review::where(['park_id' => $park->id, 'status' => 'confirmed'])->latest()->limit(10)->get();

        return compact('park', 'reviews');
    }

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
