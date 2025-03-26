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
    
}
