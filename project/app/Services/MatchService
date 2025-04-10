<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\Offer;
use Illuminate\Support\Facades\Cache;

class MatchService
{

    protected $weights = [
        'skills' => 0.40, // 40%
        'languages' => 0.20, // 20%
        'experience' => 0.25, // 25%
        'location' => 0.15, // 15%
    ];

    public function calculateMatchScore(Resume $resume, Offer $offer): float
    {
        if (!$resume || !$offer) {
            return 0;
        }
        $skillsScore = $this->calculateSkillsScore($resume, $offer);
        $languagesScore = $this->calculateLanguagesScore($resume, $offer);
        $experienceScore = $this->calculateExperienceScore($resume, $offer);
        $locationScore = $this->calculateLocationScore($resume, $offer);
        
        $totalScore = (
            ($skillsScore * $this->weights['skills']) +
            ($languagesScore * $this->weights['languages']) +
            ($experienceScore * $this->weights['experience']) +
            ($locationScore * $this->weights['location'])
        ) * 100;

        return min(100, max(0, round($totalScore, 2))); 
    }


    protected function calculateSkillsScore(Resume $resume, Offer $offer): float
    {
        $requiredSkills = $offer->skills->pluck('id')->toArray();
        
        if (empty($requiredSkills)) {
            return 1.0;
        }

        $userSkills = $resume->skills->pluck('id')->toArray();
        $matchingSkills = array_intersect($requiredSkills, $userSkills);

        $matchPercentage = count($matchingSkills) / count($requiredSkills);
        
        return $matchPercentage;
    }


    protected function calculateLanguagesScore(Resume $resume, Offer $offer): float
    {
        $requiredLanguages = $offer->languages->mapWithKeys(function($lang) {
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


    protected function calculateExperienceScore(Resume $resume, Offer $offer): float
    {
        $requiredExperience = $offer->experience;
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


    protected function calculateLocationScore(Resume $resume, Offer $offer): float
    {
        if (strtolower($resume->ville) === strtolower($offer->location)) {
            return 1.0;
        }

        if ($resume->relocation_possible) {

            if (strtolower($resume->pays) === strtolower($offer->pays)) {
                return 0.8;
            }
            return 0.6;
        }

        if (strtolower($offer->mode_travail) === 'Sur site') {
            return 0.9;
        }

        return 0;
    }


}