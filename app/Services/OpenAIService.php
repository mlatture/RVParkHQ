<?php

namespace App\Services;

use Illuminate\Support\Arr;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected CONST GOOGLE_PLACE_URL = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json";
    protected CONST GOOGLE_PLACE_DETAILS_URL = "https://maps.googleapis.com/maps/api/place/details/json";

    protected function fetchPlaceDetails($placeName, $location = null): ?array
    {
        $key = config('openai.google_api_key');
        $textSearchResponse = Http::get(self::GOOGLE_PLACE_URL, [
            'input' => $placeName . ' ' . $location,
            'inputtype' => 'textquery',
            'fields' => 'place_id',
            'key' => $key,
        ]);

        $candidates = $textSearchResponse['candidates'] ?? [];
        if (count($candidates) === 0) {
            return null;
        }

        $placeId = $candidates[0]['place_id'];
        $detailsResponse = Http::get(self::GOOGLE_PLACE_DETAILS_URL, [
            'place_id' => $placeId,
            'fields' => 'name,formatted_phone_number,website,formatted_address',
            'key' => $key,
        ]);
        $result = $detailsResponse['result'] ?? null;
        if (!$result) {
            return null;
        }

        return [
            'name' => $result['name'] ?? null,
            'phone' => $result['formatted_phone_number'] ?? null,
            'website' => $result['website'] ?? null,
            'website_url' => $result['website'] ?? null,
            'address' => $result['formatted_address'] ?? null,
        ];
    }
    
    public function extractEmailFromWebsite(string $url): ?string
    {
        try {
            $response = Http::timeout(10)->get($url);
            if (!$response->successful()) {
                return null;
            }
    
            $body = $response->body();
            
            preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/i', $body, $matches);
    
            return $matches[0] ?? null;
    
        } catch (\Exception $e) {
            return null;
        }
    }


    public function generateParkDescription(array $formData)
    {
        $data = Arr::only($formData, ['name', 'state']);
        $googleData = $this->fetchPlaceDetails($data['name'], $data['state']);
        if (!empty($googleData['website'])) {
            $email = $this->extractEmailFromWebsite($googleData['website']);
            $googleData['email'] = $email;
        }
        
        $prompt = "Given this partial data about a park:\n" . json_encode($googleData) .
            "\nFill in missing data like description, short description, city, country, postal code, zip code or other information etc.";

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $suggestedData = json_decode($response['choices'][0]['message']['content'], true);
        return response()->json(['data' => $suggestedData ?? $googleData]);
    }
}
