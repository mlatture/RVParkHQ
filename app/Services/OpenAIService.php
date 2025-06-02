<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class OpenAIService
{
    public function generateParkDescription(array $formData)
    {
        $prompt = "Given this partial data about a park:\n" . json_encode($formData) .
            "\nFill in missing data like phone, website, description, etc.";

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $content = $response['choices'][0]['message']['content'];

        $suggestedData = json_decode($content, true);

        return response()->json(['data' => $suggestedData]);
    }
}
