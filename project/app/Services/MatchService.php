<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\Offre;
use App\Models\MatchingPreference;
use Illuminate\Support\Facades\Cache;

class MatchService
{
    public function __construct(
        private ManualMatchService $manualService,
        private OpenAIMatchService $aiService,
        private OpenAIDataPreparer $dataPreparer
    ) {}

    public function calculate(Resume $resume, Offre $offer): int
    {
        // $cacheKey = "match_{$resume->id}_{$offer->id}";
        
        // return Cache::remember($cacheKey, now()->addHours(1), function() use ($resume, $offer) {
            $preferences = $offer->matchingPreference;

            if ($preferences && $preferences->use_ai) {
                try {
                    $data = $this->dataPreparer->prepare($resume, $offer);
                    return $this->aiService->calculate($data);
                } catch (\Exception $e) {
                    $weights = MatchingPreference::defaultWeights();
                    return $this->manualService->calculate($resume->id, $offer->id, $weights);
                }
            }

            $weights = $preferences ? [
                'skills' => $preferences->skills_weight ?? MatchingPreference::defaultWeights()['skills'],
                'languages' => $preferences->languages_weight ?? MatchingPreference::defaultWeights()['languages'],
                'experience' => $preferences->experience_weight ?? MatchingPreference::defaultWeights()['experience'],
                'location' => $preferences->location_weight ?? MatchingPreference::defaultWeights()['location'],
            ] : MatchingPreference::defaultWeights();

            return $this->manualService->calculate($resume->id, $offer->id, $weights);
        // });
    }
}