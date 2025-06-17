<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ParkRequest;
use App\Models\{Park, Review, WinnerPark};
use App\Services\Frontend\ReviewService;
use App\Services\ParkService;
use Illuminate\Http\Request;

class ParkController extends Controller
{
    protected $reviewService;
    protected $parkService;

    public function __construct(ReviewService $reviewService, ParkService $parkService)
    {
        $this->reviewService = $reviewService;
        $this->parkService = $parkService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['country', 'state', 'city', 'states']);
        $data['parks'] = $this->parkService->getFilteredParks($filters);

        return view('frontend.pages.park.index', $data);
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
    
    public function show($slug_path)
    {
        $data = $this->parkService->getParkDetails($slug_path);
        
        return view('frontend.pages.park.show', [
            'parks' => $data['park'],
            'reviews' => $data['reviews']
        ]);
    }
    
    public function winnerPark()
    {
        $topParkReview = Review::select('park_id')
            ->where('status', 'confirmed')
            ->groupBy('park_id')
            ->selectRaw('park_id, COUNT(*) as total_reviews')
            ->orderByDesc('total_reviews')
            ->first();

        WinnerPark::create([
            'park_id' => $topParkReview->park_id,
            'date' => now(),
        ]);
    }
}
