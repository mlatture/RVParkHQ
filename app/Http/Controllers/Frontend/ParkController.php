<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FeedBack;
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
        $data['parks'] = Park::findorFail(decrypt($id));
        return view('frontend.pages.park.show', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'park_id' => 'nullable',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $validated['ip_address'] = $request->ip();

        Feedback::create($validated);

        return response()->json(['message' => 'Thank you for your feedback!']);
    }

}
