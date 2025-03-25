<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function resumes()
    {
        return $this->belongsToMany(Resume::class, 'resume_skill');
    }

    public function offres()
    {
        return $this->belongsToMany(Resume::class, 'offer_id');
    }
    
}
