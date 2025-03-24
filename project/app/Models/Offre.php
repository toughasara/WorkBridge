<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'nombre_poste', 'type_contrat', 'mode_travail', 'description',
        'date_expiration', 'salaire', 'experience', 'location', 'statut', 'candidatures_count', 'company_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
