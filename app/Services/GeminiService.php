<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeminiService
{
    public function generateText(string $prompt): string
    {
        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model');

        if (empty($apiKey)) {
            throw new RuntimeException(
                'Gemini API key belum dikonfigurasi di file .env.'
            );
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        $response = Http::withHeaders([
            'x-goog-api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])
            ->timeout(90)
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.2,
                    'responseMimeType' => 'application/json',
                ],
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Gemini API Error: HTTP '
                . $response->status()
                . ' - '
                . $response->json('error.message', 'Terjadi kesalahan API.')
            );
        }

        $text = $response->json(
            'candidates.0.content.parts.0.text'
        );

        if (!is_string($text) || trim($text) === '') {
            throw new RuntimeException(
                'Gemini tidak memberikan respons teks.'
            );
        }

        return $text;
    }

    public function generateJson(string $prompt): array
    {
        $text = $this->generateText($prompt);

        $result = json_decode($text, true);

        if (!is_array($result)) {
            throw new RuntimeException(
                'Respons Gemini bukan JSON yang valid: ' . $text
            );
        }

        return $result;
    }
}
