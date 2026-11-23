<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenAIService
{
    public function createResponse(string $prompt): array
    {
        $apiKey = config('services.openai.api_key');
        $model = config('services.openai.model');

        if (empty($apiKey)) {
            throw new RuntimeException(
                'OpenAI API key belum dikonfigurasi.'
            );
        }

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->timeout(90)
            ->post('https://api.openai.com/v1/responses', [
                'model' => $model,
                'input' => $prompt,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'OpenAI API Error: ' . $response->body()
            );
        }

        return $response->json();
    }
}
