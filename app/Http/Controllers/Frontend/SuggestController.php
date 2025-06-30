<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\SuggestMail;
use App\Models\SuggestPark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SuggestController extends Controller
{
    public function index()
    {
        return view('frontend.pages.suggest.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'park_name'      => 'required|string|max:255',
            'city'           => 'required|string|max:255',
            'state'          => 'required|string|max:100',
            'country'        => 'required|string|max:100',
            'zip'            => 'nullable|string|max:20',
            'website_url'    => 'nullable|url|max:255',
            'social_url'     => 'nullable|url|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:20',
            'user_name'      => 'required|string|max:255',
            'user_email'     => 'required|email|max:255',
        ]);

        SuggestPark::create($validated);
        Mail::to('mark@latture.com')->send(new SuggestMail((object)$validated));

        return redirect()->route('rv-park.home')->with([
            'icon' => 'success',
            'success' => 'Thank you! Your suggestion park has been submitted.'
        ]);
    }
}
