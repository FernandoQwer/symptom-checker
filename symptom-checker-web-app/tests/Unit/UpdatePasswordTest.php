<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;


    public function testupdateUser()
    {
        $userData = [
            'email' => 'john2@example.com',
            'password' => Hash::make('password123'),
            'role'  => 'patient',
            'is_active' => TRUE
        ];

        $user = User::create($userData);

        $newPassword = Hash::make('passwordnew');

        $this->actingAs($user);

        $response = $this->put('patient/update-password', [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));
    }
}
