<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('index');
});

// Auth Views
Route::middleware(['guest'])->group(function () {
    Route::get('login', function () {
        return view('login');
    })->name('login');
    Route::get('register', function () {
        return view('register');
    });

    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('create-new-patient', [AuthController::class, 'patientRegister'])->name('patient.register');
});



Route::middleware(['auth'])->group(function () {
    Route::get('patient/dashboard', function () {
        return view('patient/dashboard');
    })->name('patient.dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});



Route::get('about', function () {
    return view('about');
});
