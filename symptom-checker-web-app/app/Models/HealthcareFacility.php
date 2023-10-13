<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthcareFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'profile_image',
        'type',
        'contact_phone',
        'contact_email',
        'user_id',
        'address_id'
    ];

    protected $table = "healthcare_facilities";
}
