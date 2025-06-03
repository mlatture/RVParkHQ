<?php

namespace App\Services;

use Illuminate\Support\Arr;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected CONST GOOGLE_API_KEY = "AIzaSyAU7oE95QhMVyp3yEnXqZRxzm4O3KqPO9A";//"AIzaSyB-sXnc7p372A2Okp1YRuia8PLtmY-xTzM";

    protected CONST GOOGLE_PLACE_URL = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json";
    protected CONST GOOGLE_PLACE_DETAILS_URL = "https://maps.googleapis.com/maps/api/place/details/json";

    protected function fetchPlaceDetails($placeName, $location = null): ?array
    {
        $textSearchResponse = Http::get(self::GOOGLE_PLACE_URL, [
            'input' => $placeName . ' ' . $location,
            'inputtype' => 'textquery',
            'fields' => 'place_id',
            'key' => self::GOOGLE_API_KEY,
        ]);

        $candidates = $textSearchResponse['candidates'] ?? [];
        if (count($candidates) === 0) {
            return null;
        }

        $placeId = $candidates[0]['place_id'];
        $detailsResponse = Http::get(self::GOOGLE_PLACE_DETAILS_URL, [
            'place_id' => $placeId,
            'fields' => 'name,formatted_phone_number,website,formatted_address',
            'key' => self::GOOGLE_API_KEY,
        ]);
        $result = $detailsResponse['result'] ?? null;
        if (!$result) {
            return null;
        }

        return [
            'name' => $result['name'] ?? null,
            'phone' => $result['formatted_phone_number'] ?? null,
            'website' => $result['website'] ?? null,
            'address' => $result['formatted_address'] ?? null,
        ];
    }

    public function generateParkDescription(array $formData)
    {
        $data = Arr::only($formData, ['name', 'state']);
        $googleData = $this->fetchPlaceDetails($data['name'], $data['state']);
        $prompt = "Given this partial data about a park:\n" . json_encode($googleData) .
            "\nFill in missing data like phone, website, description, etc.";

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $suggestedData = json_decode($response['choices'][0]['message']['content'], true);
        $suggestedData['website_url'] = $suggestedData['website'];
        return response()->json(['data' => $suggestedData]);
    }
    
    // public function generateParkDescription(array $formData)
    // {
    //     $prompt = "Given this partial data about a park:\n" . json_encode($formData) .
    //         "\nFill in missing data like phone, website, description, etc.";

    //     $response = OpenAI::chat()->create([
    //         'model' => 'gpt-4',
    //         'messages' => [
    //             ['role' => 'user', 'content' => $prompt],
    //         ],
    //     ]);

    //     $content = $response['choices'][0]['message']['content'];

    //     $suggestedData = json_decode($content, true);

    //     return response()->json(['data' => $suggestedData]);
    // }
}
