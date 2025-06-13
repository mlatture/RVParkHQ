<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ParkRequest;
use App\Models\{Park, Review};
use Illuminate\Http\Request;
use App\Services\Frontend\ReviewService;


class ParkController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['country', 'state', 'city', 'states']);
        $data['parks'] = $this->reviewService->getFilteredParks($filters);

        return view('frontend.pages.park.index', $data);
    }

    public function show($country, $state, $city, $campground, $id)
    {
        $data = $this->reviewService->getParkDetails($id);

        return view('frontend.pages.park.show', [
            'parks' => $data['park'],
            'reviews' => $data['reviews']
        ]);
    }

    public function pendingReview(ParkRequest $request)
    {
        $this->reviewService->storePendingReview($request->validated());

        return response()->json([
            'message' => 'A confirmation email has been sent. Please check your inbox.',
            'icon' => 'success'
        ]);
    }

    public function confirmReview($token)
    {
        $status = $this->reviewService->confirmReview($token);

        if ($status === 'already_submitted') {
            return redirect()->route('rv-park.park')
                ->with([
                    'success' => 'A review has already been submitted for this park using your email address.',
                    'icon' => 'info'
                ]);
        }

        return redirect()->route('rv-park.park')
            ->with([
                'success' => 'Your review has been confirmed and submitted.',
                'icon' => 'success'
            ]);
    }
}
