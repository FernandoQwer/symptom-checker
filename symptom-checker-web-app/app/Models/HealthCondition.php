<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'condition',
        'description',
        'severity_level',
    ];

    protected $table = "health_conditions";
}
