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

    // Relation many-to-many avec la table `skills`
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'offer_skill', 'offer_id', 'skill_id');
    }

    // Relation many-to-many avec la table `languages`
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
            'id', // Clé étrangère sur la table users
            'user_id', // Clé étrangère sur la table companies
            'user_id', // Clé locale sur la table offres
            'id' // Clé locale sur la table users
        );
    }

    public function matchingPreference()
    {
        return $this->hasOne(MatchingPreference::class, 'offer_id');
    }
    
}
