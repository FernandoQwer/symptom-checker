<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSymptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'prediction_id',
        'symptom_id'
    ];

    protected $table = "user_symptoms";
}
