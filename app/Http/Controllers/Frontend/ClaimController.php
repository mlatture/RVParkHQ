<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ClaimParkVerifyMail;
use App\Models\ClaimPark;
use App\Models\ClaimParkSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ClaimController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'park_id' => 'required',
            'park_name' => 'required|string|max:255',
            'park_url' => 'nullable|url',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'email' => 'required|email|unique:claim_park_submissions,email',
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string',
            'password' => 'required|string|min:6',
        ]);

        $token = Str::random(40);

        $submission = ClaimParkSubmission::create([
            'park_id' => $request->park_id,
            'park_name' => $request->park_name,
            'park_url' => $request->park_url,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'password' => Hash::make($request->password),
            'verify_token' => $token,
        ]);

        // Send verification email
        Mail::to($request->email)->send(new ClaimParkVerifyMail($submission));

        // Send to GoHighLevel
        try {
            $client = new \GuzzleHttp\Client;

            $response = $client->post(config('services.gohighlevel.base_url').'/contacts', [
                'headers' => [
                    'Authorization' => 'Bearer '.config('services.gohighlevel.api_key'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'locationId' => config('services.gohighlevel.location_id'),
                    'firstName' => $request->park_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'tags' => 'Claim A Park',
                    'customField' => [
                        // Optional: include URL or address if needed
                        'Park URL' => $request->park_url,
                        'City' => $request->city,
                        'State' => $request->state,
                    ],
                ],
            ]);

            if (in_array($response->getStatusCode(), [200, 201])) {
                \Log::info('Contact sent to GoHighLevel successfully.');
            } else {
                \Log::warning('GoHighLevel responded with status: '.$response->getStatusCode());
            }

        } catch (\Exception $e) {
            \Log::error('Error sending contact to GoHighLevel: '.$e->getMessage());
        }

        return redirect()->route('campgrounds.index')
            ->with([
                'success' => 'Email has been sent. Please verify your email address.',
                'icon' => 'success',
            ]);
    }

    public function verify($token)
    {
        $submission = ClaimParkSubmission::where('verify_token', $token)->firstOrFail();

        if ($submission->is_verified == 1) {
            return redirect()->route('campgrounds.index')
                ->with([
                    'success' => 'You are already verified. Please wait.',
                    'icon' => 'info',
                ]);
        }

        // Create local record
        $claimPark = ClaimPark::create([
            'contact_name' => explode('@', $submission->email)[0] ?? 'N/A',
            'contact_email' => $submission->email,
            'contact_phone' => $submission->phone,
            'park_id' => $submission->park_id,
            'status' => 'pending',
        ]);

        $submission->is_verified = 1;
        $submission->save();

        return redirect()->route('campgrounds.index')
            ->with([
                'success' => 'Email has been sent. Please verify your email address.',
                'icon' => 'success',
            ]);
    }
}
