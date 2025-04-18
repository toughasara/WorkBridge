<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'statut',
        'role_id',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    // Relation one-to-many avec la table `company`
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    // Relation one-to-many avec la table `cvs`
    public function cvs()
    {
        return $this->hasOne(Cv::class);
    }

    // Relation one-to-one avec la table `resumes`
    public function resume()
    {
        return $this->hasOne(Resume::class);
    }

    // Relation one-to-many avec la table `offres`
    public function offres()
    {
        return $this->hasMany(Offre::class);
    }

    public function hasAppliedToJob($offerId)
    {
        return $this->applications()->where('offer_id', $offerId)->exists();
    }

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }
}
