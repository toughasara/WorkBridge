<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class OpenAIMatchService
{

    public function calculate(array $data): int
    {
        $cacheKey = "ai_match_" . md5(json_encode($data));
        
        return Cache::remember($cacheKey, now()->addHours(6), function() use ($data) {
            $prompt = $this->generatePrompt($data);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json'
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an HR expert. Reply only with a number between 0-100.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.2,
                'max_tokens' => 5
            ]);

            if (!$response->successful()) {
                throw new \Exception("OpenAI API request failed: " . $response->body());
            }

            return $this->parseResponse($response->json());
        });
    }

    protected function generatePrompt(array $data): string
    {
        $resume = $data['resume'];
        $offer = $data['offer'];

        $prompt = "Calculate matching score (0-100) between candidate and job:\n\n";
        $prompt .= "Candidate Skills: " . implode(', ', $resume['skills']) . "\n";
        $prompt .= "Candidate Languages:\n";
        foreach ($resume['languages'] as $lang) {
            $prompt .= "- {$lang['name']} ({$lang['level']})\n";
        }
        $prompt .= "Total Experience: {$resume['experience']} years\n";
        $prompt .= "Location: {$resume['location']['city']}, {$resume['location']['country']}";
        $prompt .= $resume['location']['relocation'] ? " (open to relocate)\n\n" : "\n\n";

        $prompt .= "Job Requirements:\n";
        $prompt .= "Required Skills: " . implode(', ', $offer['requirements']['skills']) . "\n";
        $prompt .= "Required Languages:\n";
        foreach ($offer['requirements']['languages'] as $lang) {
            $prompt .= "- {$lang['name']} ({$lang['level']})\n";
        }
        $prompt .= "Required Experience: {$offer['requirements']['experience']} years\n";
        $prompt .= "Location: {$offer['requirements']['location']}\n";
        $prompt .= "Work Mode: {$offer['requirements']['work_mode']}\n\n";
        $prompt .= "Provide only the matching score (0-100) based on these factors:";

        return $prompt;
    }

    protected function parseResponse($response): int
    {
        if (!isset($response['choices'][0]['message']['content'])) {
            throw new \Exception("Invalid OpenAI API response structure");
        }
        $score = (int) trim($response->choices[0]->message->content);
        return min(100, max(0, $score));
    }
}