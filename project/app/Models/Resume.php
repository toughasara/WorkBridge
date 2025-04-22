<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pays',
        'ville',
        'phone',
        'birthDate',
        'relocation_possible',
    ];

    // Relation belongsTo avec le modèle `User`
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation one-to-many avec la table `experiences`
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    // Relation one-to-many avec la table `education`
    public function education()
    {
        return $this->hasMany(Education::class);
    }

    // Relation many-to-many avec la table `skills`
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'resume_skill');
    }

    // Relation many-to-many avec la table `languages`
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'resume_language')
                    ->withPivot('level');
    }
    
}
