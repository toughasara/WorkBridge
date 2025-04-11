<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchingPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'use_ai',
        'skills_weight',
        'languages_weight',
        'experience_weight',
        'location_weight'
    ];

    public static function defaultWeights(): array
    {
        return [
            'skills' => 0.40,
            'languages' => 0.20,
            'experience' => 0.25,
            'location' => 0.15,
        ];
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    
}
