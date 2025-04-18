<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\Offre;

class OpenAIDataPreparer
{
    public function prepare(Resume $resume, Offre $offre): array
    {
        return [
            'resume' => [
                'skills' => $resume->skills->pluck('name')->toArray(),
                'languages' => $resume->languages->map(function($lang) {
                    return [
                        'name' => $lang->name,
                        'level' => $lang->pivot->level
                    ];
                })->toArray(),
                'experience' => $resume->experiences->sum(function($exp) {
                    return $exp->end_date 
                        ? $exp->start_date->diffInYears($exp->end_date)
                        : $exp->start_date->diffInYears(now());
                }),
                'location' => [
                    'city' => $resume->ville,
                    'country' => $resume->pays,
                    'relocation' => $resume->relocation_possible
                ]
            ],
            'offre' => [
                'requirements' => [
                    'skills' => $offre->skills->pluck('name')->toArray(),
                    'languages' => $offre->languages->map(function($lang) {
                        return [
                            'name' => $lang->name,
                            'level' => $lang->pivot->level
                        ];
                    })->toArray(),
                    'experience' => $offre->experience,
                    'location' => $offre->location,
                    'work_mode' => $offre->mode_travail
                ]
            ]
        ];
    }
}