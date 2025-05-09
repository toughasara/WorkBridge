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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'resume_skill');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'resume_language')
                    ->withPivot('level');
    }
    
}
