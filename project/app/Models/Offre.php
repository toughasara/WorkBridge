<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'nombre_poste', 'type_contrat', 'mode_travail', 'description',
        'date_expiration', 'salaire', 'experience', 'location', 'statut', 'candidatures_count', 'company_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'offer_skill', 'offer_id', 'skill_id');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'offer_language', 'offer_id', 'language_id')
                    ->withPivot('level');
    }

    public function company()
    {
        return $this->hasOneThrough(
            Company::class,
            User::class,
            'id', 
            'user_id',
            'user_id',
            'id'
        );
    }

    public function matchingPreference()
    {
        return $this->hasOne(MatchingPreference::class, 'offer_id');
    }
    
    public function applications()
    {
        return $this->hasMany(Application::class, 'offre_id');
    }
}
