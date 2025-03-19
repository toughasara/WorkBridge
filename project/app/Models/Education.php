<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = ['candidate_id', 'institution_name', 'degree', 'field_of_study', 'start_date', 'end_date'];

    public function candidate() {
        return $this->belongsTo(Candidate::class);
    }
}
