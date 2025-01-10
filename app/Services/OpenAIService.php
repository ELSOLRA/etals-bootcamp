<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class OpenAIservice
{
    public function generateChirps(): array
    {
        $prompt =
            "Generate 3 short social media posts (max 255 characters each) with different tones: 1. Serious 2. Casual 3. Humorous. Format as JSON object with keys: serious, casual, funny";


        $respones = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],

        ]);

        return json_decode($respones->choices[0]->message->content, true);
    }
}
