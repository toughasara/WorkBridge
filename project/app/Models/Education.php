<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'institution_name',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
    ];

    // Relation belongsTo avec le modèle `Resume`
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

}
