<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'prediction',
        'score',
        'patient_id',
        'health_condition_id'
    ];

    protected $table = "Predictions";
}
