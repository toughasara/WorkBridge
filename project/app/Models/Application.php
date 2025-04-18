<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'offer_id',
        'resume_id',
        'cv_id',
        'status',
        'match_score',
        'feedback',
        'applied_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($application) {
            $application->applied_at = now();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offre::class, 'offer_id');
    }

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}
