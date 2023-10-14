<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HealthcareFacilityController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SymptomCheckerController;

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

    Route::get('/healthcare-facility-register', function () {
        return view('healthcare-facility-register');
    });

    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('create-new-patient', [AuthController::class, 'patientRegister'])->name('patient.register');
    Route::post('create-new-healthcare-facility', [AuthController::class, 'healthcareFacilityRegister'])->name('healthcare-facility.register');
});



Route::get('/symptom-checker', [SymptomCheckerController::class, 'symptomCheckerView']);
Route::post('/predict', [SymptomCheckerController::class, 'predict']);


Route::middleware(['auth'])->group(function () {

    // return view('patient/dashboard');

    Route::get('/healthcare-facility/dashboard', [HealthcareFacilityController::class, 'dashboard'])->name('healthcare-facility.dashboard');
    
    
    Route::get('/patient/add-new-appointment/{predictionID}', [PatientController::class, 'newAppointmentPage']);
    
    Route::get('patient/dashboard', [PatientController::class, 'patientDashboard'])->name('patient.dashboard');
    Route::get('patient/change-password', [PatientController::class, 'changePasswordView'])->name('patient.change-password');
    Route::get('patient/predictions', [PatientController::class, 'predictionResultsView'])->name('patient.predictions');
    
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::put('patient/update-profile', [PatientController::class, 'updatePatient'])->name('patient.update');
    Route::put('patient/update-password', [PatientController::class, 'updatePassword'])->name('patient.update-password');
});



Route::get('about', function () {
    return view('about');
});
