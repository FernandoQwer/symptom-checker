<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use DateProcessor;

class PatientRegisterTest extends TestCase
{
    use RefreshDatabase;


    public function testUserCanRegister()
    {
        $userData = [
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'role'  => 'patient',
            'is_active' => TRUE
        ];

        $addressData = [
            'address_line_one' => '123',
            'address_line_two' => 'Main Street',
            'city' => 'Colombo 04',
            'postal_code' => '12000',
        ];

        // New User
        $user = User::create($userData);
        // New Address
        $address = Address::create($addressData);


        $patientData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'gender' => 'male',
            'mobile' => '0777123456',
            'dob' => '2000-01-01',
            'user_id' => $user->id,
            'address_id' => $address->id
        ];

        $patient = Patient::create($patientData);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
        $this->assertDatabaseHas('patients', ['first_name' => 'John', 'last_name' => 'Doe']);
    }
}
