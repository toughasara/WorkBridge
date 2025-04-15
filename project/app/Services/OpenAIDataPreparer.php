<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\Offer;

class OpenAIDataPreparer
{
    public function prepare(Resume $resume, Offer $offer): array
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
            'offer' => [
                'requirements' => [
                    'skills' => $offer->skills->pluck('name')->toArray(),
                    'languages' => $offer->languages->map(function($lang) {
                        return [
                            'name' => $lang->name,
                            'level' => $lang->pivot->level
                        ];
                    })->toArray(),
                    'experience' => $offer->experience,
                    'location' => $offer->location,
                    'work_mode' => $offer->mode_travail
                ]
            ]
        ];
    }
}