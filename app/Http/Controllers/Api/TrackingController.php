<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Park;
use App\Models\Hit;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TrackingController extends Controller
{
    public function track(Request $request, $slug)
    {
        try {
            $park = Park::whereSlug($slug)->first();
            if (!$park) return response()->json(['error' => 'Invalid park'], 404);
        
            Hit::create([
                'park_id' => $park->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'source' => 'badge',
            ]);
        
            
            $pixelId = config('app.fb_pixel_id');
            $accessToken = config('app.fb_pixel_access_token');
            $fbBaseUrl = config('app.fb_pixel_base_url');
            
            $response = retry(3, function () use ($pixelId, $accessToken, $fbBaseUrl, $park) {
                $client = new Client();
            
                return $client->post("{$fbBaseUrl}/{$pixelId}/events", [
                    'timeout' => 10,
                    'json' => [
                        'data' => [
                            [
                                'event_name' => 'ViewContent',
                                'event_time' => time(),
                                'event_source_url' => "https://rvparkhq.com/parks/{$park->slug}/reviews",
                                'user_data' => [
                                    'client_ip_address' => request()->ip(),
                                    'client_user_agent' => request()->userAgent(),
                                ],
                                'custom_data' => [
                                    'park_slug' => $park->slug,
                                ],
                                'action_source' => 'website',
                            ]
                        ],
                        'access_token' => $accessToken,
                    ]
                ]);
            }, 200);
            
            $body = json_decode($response->getBody()->getContents(), true);
            return response()->json([
                'status' => 'success',
                'response' => $body,
            ], $response->getStatusCode());
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
