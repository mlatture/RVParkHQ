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
            'zip'            => 'nullable|string|max:20',
            'website_url'    => 'nullable|max:255',
            'email'          => 'required|email|max:255|unique:suggest_park,email',
            'phone'          => 'nullable|string|max:20',
            'user_name'      => 'required|string|max:255',
            'user_email'     => 'required|email|max:255',
            'submitted_by'   => 'required',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'max:255',
            'description'    => 'max:1000',
        ]);

        SuggestPark::create($validated);
        
        Mail::to(config('mail.notification_email'))->send(new SuggestMail((object)$validated));

        return redirect()->route('rv-park.home')->with([
            'icon' => 'success',
            'success' => 'Thanks! We’ll review your submission and add the park soon.'
        ]);
    }
}
