<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Park;
use Illuminate\Http\Request;

class ParkController extends Controller
{
    public function index()
    {
        $data['parks'] = Park::paginate(12);

        return view('frontend.pages.park.index', $data);
    }

    public function show($country, $state, $city, $campground, $id)
    {
        $data['parks']      = Park::findorFail(decrypt($id));
        $data['reviews']    = Review::latest()->limit(10)->get();
        return view('frontend.pages.park.show', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'park_id' => 'required|exists:parks,id',
            'rating' => 'required|integer|min:1|max:5',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:reviews,email',
            'message' => 'required|string|min:10',
        ]);

        $validated['ip_address'] = $request->ip();

        Review::create($validated);

        return response()->json(['message' => 'Thank you for supporting this park! Your review brings it one step closer to being recognized in the RVParkHQ Excellence Awards.']);
    }

}
