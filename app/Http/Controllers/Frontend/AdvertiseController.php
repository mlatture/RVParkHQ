<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AdInquiries;
use App\Mail\AdvertiseSubmissionMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    public function index()
    {
        return view('frontend.pages.advertise.index');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'company'  => 'nullable|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'nullable|string|max:30',
            'interest' => 'nullable|string|max:100',
            'message'  => 'nullable|string',
        ]);

        $data = $request->only([
            'name', 'company', 'email', 'phone', 'interest', 'message'
        ]);
        AdInquiries::create($data);
        
        Mail::to(config('mail.notification_email'))->send(new AdvertiseSubmissionMail($data));
        
        return redirect()->back()->with([
            'icon' => 'success',
            'success' => 'Thank you! Your inquiry has been submitted.',
        ]);
    }
}