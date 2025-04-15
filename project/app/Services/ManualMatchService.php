<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\Offre;
use Illuminate\Support\Facades\Cache;

class ManualMatchService
{
    public function calculate(int $resumeId, int $OfferId, array $weights): int
    {
        // $cacheKey = "manual_match_{$resumeId}_{$OfferId}_" . md5(json_encode($weights));
        
        // return Cache::remember($cacheKey, now()->addHours(1), function() use ($resumeId, $OfferId, $weights) {
            $resume = Resume::with(['skills', 'languages', 'experiences'])->findOrFail($resumeId);
            $Offre = Offre::with(['skills', 'languages'])->findOrFail($OfferId);

            $skillsScore = $this->calculateSkillsScore($resume, $Offre);
            $languagesScore = $this->calculateLanguagesScore($resume, $Offre);
            $experienceScore = $this->calculateExperienceScore($resume, $Offre);
            $locationScore = $this->calculateLocationScore($resume, $Offre);

            $totalScore = (
                ($skillsScore * $weights['skills']) +
                ($languagesScore * $weights['languages']) +
                ($experienceScore * $weights['experience']) +
                ($locationScore * $weights['location'])
            ) * 100;

            return min(100, max(0, (int) round($totalScore)));
        // });
    }

    protected function calculateSkillsScore(Resume $resume, Offre $Offre): float
    {
        $requiredSkills = $Offre->skills->pluck('id')->toArray();
        
        if (empty($requiredSkills)) {
            return 1.0;
        }

        $userSkills = $resume->skills->pluck('id')->toArray();
        $matchingSkills = array_intersect($requiredSkills, $userSkills);

        return count($matchingSkills) / count($requiredSkills);
    }

    protected function calculateLanguagesScore(Resume $resume, Offre $Offre): float
    {
        $requiredLanguages = $Offre->languages->mapWithKeys(function($lang) {
            return [$lang->id => strtolower($lang->pivot->level)];
        });

        if ($requiredLanguages->isEmpty()) {
            return 1.0;
        }

        $userLanguages = $resume->languages->mapWithKeys(function($lang) {
            return [$lang->id => strtolower($lang->pivot->level)];
        });

        $scores = [];
        $levelWeights = [
            'débutant' => 0.3,
            'intermédiaire' => 0.6,
            'avancé' => 0.8,
            'courant' => 1.0,
            'bilingue' => 1.2
        ];

        foreach ($requiredLanguages as $langId => $requiredLevel) {
            if ($userLanguages->has($langId)) {
                $userLevel = $userLanguages->get($langId);
                $requiredWeight = $levelWeights[$requiredLevel] ?? 0.6;
                $userWeight = $levelWeights[$userLevel] ?? 0.3;
                
                $scores[] = min(1.0, $userWeight / $requiredWeight);
            } else {
                $scores[] = 0;
            }
        }

        return array_sum($scores) / count($scores);
    }

    protected function calculateExperienceScore(Resume $resume, Offre $Offre): float
    {
        $requiredExperience = $Offre->experience;
        $userExperience = $resume->experiences->sum(function($exp) {
            return $exp->end_date 
                ? $exp->start_date->diffInYears($exp->end_date)
                : $exp->start_date->diffInYears(now());
        });

        if ($requiredExperience <= 0) {
            return 1.0;
        }

        if ($userExperience >= $requiredExperience) {
            return 1.0;
        }

        return min(1.0, $userExperience / $requiredExperience);
    }

    protected function calculateLocationScore(Resume $resume, Offre $Offre): float
    {
        if (strtolower($resume->ville) === strtolower($Offre->location)) {
            return 1.0;
        }

        if ($resume->relocation_possible) {
            if (strtolower($resume->pays) === strtolower($Offre->pays)) {
                return 0.8;
            }
            return 0.6;
        }

        if (strtolower($Offre->mode_travail) === 'remote') {
            return 0.9;
        }

        return 0;
    }
}