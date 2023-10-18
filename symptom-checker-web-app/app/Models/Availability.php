<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'healthcare_provider_id'
    ];

    protected $table = "availability";
}
