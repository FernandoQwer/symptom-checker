<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthcareProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'contact_phone',
        'contact_email',
        'specialty_id',
        'healthcare_facility_id',
        'status'
    ];

    protected $table = "healthcare_providers";
}
