<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ParkRequest;
use App\Models\Park;
use App\Models\Review;
use App\Models\WinnerPark;
use App\Models\Favorite;
use App\Services\Frontend\ReviewService;
use App\Services\ParkService;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

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
        if(!empty($request->segment('4'))) {
            $filters['state'] = $request->segment('4');
            $data['parks'] = $this->parkService->getFilteredParks($filters);    
        } else {
            $filters = $request->only(['country', 'state', 'city', 'states', 'global_search', 'site_availability', 'amenities']);
            $data['parks'] = $this->parkService->getFilteredParks($filters);   
        }
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
            'reviews' => $data['reviews'],
            'approvedClaim' => $data['approvedClaim'] ?? null,
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
    
    public function parkCountry()
    {
        $states = Park::select('state', 'color')->distinct()->orderBy('state')->get();
        return view('frontend.pages.park.state', compact('states'));
    }
    
    public function favoritePark(Request $request)
    {
        $request->validate(['park_id' => 'required|exists:parks,id']);
        $user = Auth::user();
        $parkId = $request->park_id;
        if (!$user->favorites()->where('park_id', $parkId)->exists()) {
            $user->favorites()->create(['park_id' => $parkId]);
        }
        return response()->json(['status' => 'favorited']);
    }
    
    public function unfavoritePark(Request $request)
    {
        $request->validate(['park_id' => 'required|exists:parks,id']);
        $user = Auth::user();
        $parkId = $request->park_id;
        $user->favorites()->where('park_id', $parkId)->delete();
        return response()->json(['status' => 'unfavorited']);
    }
    
    public function generateBadge($slug) {
        $park = Park::whereSlug($slug)->firstOrFail();
        $awards = $park->winnerParks;
        //$awards = ['2025' => 'Gold', '2026' => 'Silver'];
        
        
        // $img = Image::canvas(768, 768, '#ffffff');

        // // // Load shield image or draw one (optional)
        // $shield = Image::make(public_path('images/blank_sheild.png'))
        //     ->resize(700, 700)
        //     ->opacity(100)
        //     ->brightness(10);
    
        // $img->insert($shield, 'center');
        
        $img = Image::canvas(300, 300, [0, 0, 0, 0]);
        
        $shield = Image::make(public_path('images/blank_sheild.png'))
            ->resize(280, 280, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
    
        // STEP 3: Insert shield centered
        $img->insert($shield, 'center');
        
        $img->text('Review Us', 150, 130, function ($font) {
            $font->file(public_path('fonts/OpenSans-Bold.ttf'));
            $font->size(18);
            $font->color('#ffffff');
            $font->align('center');
        });
        
        $img->text('On', 150, 155, function ($font) {
            $font->file(public_path('fonts/OpenSans-Bold.ttf'));
            $font->size(16);
            $font->color('#ffffff');
            $font->align('center');
        });
    
        $img->text('RVParkHQ', 150, 185, function ($font) {
            $font->file(public_path('fonts/OpenSans-Bold.ttf'));
            $font->size(18);
            $font->color('#000000');
            $font->align('center');
        });
    
        if($awards->count() > 0) {
            $y = 80;
            foreach ($awards as $year => $level) {
                $img->text("🏅 $year $level", 300, $y, function ($font) {
                    $font->file(public_path('fonts/OpenSans-Regular.ttf'));
                    $font->size(18);
                    $font->color('#666666');
                    $font->align('center');
                });
                $y += 20;
            }   
        }
        
        return $img->response('png');
    }
}
