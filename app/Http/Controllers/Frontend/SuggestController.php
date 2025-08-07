<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\SuggestMail;
use App\Models\SuggestPark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;

class SuggestController extends Controller
{
    public function index()
    {
        return view('frontend.pages.suggest.index');
    }

//    public function store(Request $request)
//    {
//        $validated = $request->validate([
//            'park_name'      => 'required|string|max:255',
//            'city'           => 'required|string|max:255',
//            'state'          => 'required|string|max:100',
////            'country'        => 'required|string|max:100',
//            'zip'            => 'nullable|string|max:20',
//            'website_url'    => 'nullable|url|max:255',
////            'social_url'     => 'nullable|url|max:255',
//            'email'             => 'required|email|max:255|unique:suggest_park,email',
//            'phone'          => 'nullable|string|max:20',
//            'user_name'      => 'required|string|max:255',
//            'user_email'     => 'required|email|max:255',
//            'submitted_by'     => 'required',
//            'address_line_1'     => 'required|string|max:255',
//            'address_line_2'     => 'nullable|string|max:255',
//            'description'     => 'nullable|string|max:1000',
//        ]);
//        SuggestPark::create($validated);
//        Mail::to(config('mail.notification_email'))->send(new SuggestMail((object)$validated));
//
//        return redirect()->route('rv-park.home')->with([
//            'icon' => 'success',
//            'success' => 'Thanks! We’ll review your submission and add the park soon.'
//        ]);
//    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'park_name'      => 'required|string|max:255',
    //         'city'           => 'required|string|max:255',
    //         'state'          => 'required|string|max:100',
    //         'zip'            => 'nullable|string|max:20',
    //         'website_url'    => 'nullable|url|max:255',
    //         'email'          => 'required|email|max:255|unique:suggest_park,email',
    //         'phone'          => 'nullable|string|max:20',
    //         'user_name'      => 'required|string|max:255',
    //         'user_email'     => 'required|email|max:255',
    //         'submitted_by'   => 'required',
    //         'address_line_1' => 'required|string|max:255',
    //         'address_line_2' => 'nullable|string|max:255',
    //         'description'    => 'nullable|string|max:1000',
    //         'user_sms_optin'    => 'nullable',
    //     ]);

    //     // Store suggestion
    //     SuggestPark::create($validated);

    //     // Send notification email
    //     Mail::to(config('mail.notification_email'))->send(new SuggestMail((object)$validated));

    //     // Send contact to GoHighLevel
    //     try {
    //         $client = new Client();
    //         $response = $client->post(config('services.gohighlevel.base_url') . '/contacts/', [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . config('services.gohighlevel.api_key'),
    //                 'Content-Type'  => 'application/json',
    //                 'Accept'        => 'application/json',
    //             ],
    //             'json' => [
    //                 'locationId' => config('services.gohighlevel.location_id'),
    //                 'firstName'  => $validated['user_name'],
    //                 'email'      => $validated['user_email'],
    //                 'phone'      => $validated['phone'] ?? null,
    //                 'tags'       => ['Suggest A Park'],
    //             ],
    //         ]);

    //         if ($response->getStatusCode() === 200 || $response->getStatusCode() === 201) {
    //             \Log::info('Suggest A Park contact sent to GoHighLevel successfully.');
    //         } else {
    //             \Log::warning('GoHighLevel responded with status: ' . $response->getStatusCode());
    //         }
    //     } catch (\Exception $e) {
    //         \Log::error('Error sending Suggest A Park contact to GoHighLevel: ' . $e->getMessage());
    //     }

    //     return redirect()->route('rv-park.home')->with([
    //         'icon'    => 'success',
    //         'success' => 'Thanks! We’ll review your submission and add the park soon.'
    //     ]);
    // }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'park_name'      => 'required|string|max:255',
            'city'           => 'required|string|max:255',
            'state'          => 'required|string|max:100',
            'zip'            => 'nullable|string|max:20',
            'website_url'    => 'nullable|url|max:255',
            'email'          => 'required|email|max:255|unique:suggest_park,email',
            'phone'          => 'nullable|string|max:20',
            'user_name'      => 'required|string|max:255',
            'user_email'     => 'required|email|max:255',
            'submitted_by'   => 'required',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'description'    => 'nullable|string|max:1000',
            'user_sms_optin' => 'nullable|in:on,1',
        ]);
    
        // Store suggestion
        SuggestPark::create($validated);
    
        // Send notification email
        Mail::to(config('mail.notification_email'))->send(new SuggestMail((object)$validated));
    
        // Send contact to GoHighLevel
        try {
            $client = new Client();
    
            // Prepare base contact payload
            $payload = [
                'locationId' => config('services.gohighlevel.location_id'),
                'firstName'  => $validated['user_name'],
                'email'      => $validated['user_email'],
                'tags'       => ['Suggest A Park'],
            ];
    
            // If checkbox is checked (either 'on' or '1'), include phone
            if (!empty($validated['user_sms_optin']) && !empty($validated['phone'])) {
                $payload['phone'] = $validated['phone'];
            }
    
            $response = $client->post(config('services.gohighlevel.base_url') . '/contacts/', [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.gohighlevel.api_key'),
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                ],
                'json' => $payload,
            ]);
    
            if (in_array($response->getStatusCode(), [200, 201])) {
                \Log::info('Suggest A Park contact sent to GoHighLevel successfully.');
            } else {
                \Log::warning('GoHighLevel responded with status: ' . $response->getStatusCode());
            }
        } catch (\Exception $e) {
            \Log::error('Error sending Suggest A Park contact to GoHighLevel: ' . $e->getMessage());
        }
    
        return redirect()->route('rv-park.home')->with([
            'icon'    => 'success',
            'success' => 'Thanks! We’ll review your submission and add the park soon.'
        ]);
    }
}
