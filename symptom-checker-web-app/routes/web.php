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


Route::get('/symptom-checker', [SymptomCheckerController::class, 'symptomCheckerView'])->name('symptom-checker');
Route::post('/predict', [SymptomCheckerController::class, 'predict']);


Route::middleware(['auth'])->group(function () {

    // return view('patient/dashboard');

    Route::get('/healthcare-facility/dashboard', [HealthcareFacilityController::class, 'dashboard'])->name('healthcare-facility.dashboard');
    Route::get('/healthcare-facility/appointments', [HealthcareFacilityController::class, 'getAppointments'])->name('healthcare-facility.appointments');
    
    
    Route::get('/patient/add-new-appointment/{predictionID}', [PatientController::class, 'newAppointmentPage']);
    
    Route::get('/patient/dashboard', [PatientController::class, 'patientDashboard'])->name('patient.dashboard');
    Route::get('/patient/change-password', [PatientController::class, 'changePasswordView'])->name('patient.change-password');
    Route::get('patient/predictions', [PatientController::class, 'predictionResultsView'])->name('patient.predictions');
    Route::get('/patient/appointments', [PatientController::class, 'appointmentsView'])->name('patient.appointments');
    Route::post('/patient/create-an-appointment', [PatientController::class, 'createAppointment'])->name('patient.new-appointment');
    Route::get('/patient/appointment/view/{appointmentID}', [PatientController::class, 'appointment']);
    Route::post('/add-user-feedback', [PatientController::class, 'newUserFeedback']);
    

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::put('/patient/update-profile', [PatientController::class, 'updatePatient'])->name('patient.update');
    Route::put('/patient/update-image', [PatientController::class, 'updateProfileImage']);
    Route::put('/patient/update-password', [PatientController::class, 'updatePassword'])->name('patient.update-password');

    Route::get('/healthcare-facility/change-password', [HealthcareFacilityController::class, 'changePasswordView'])->name('healthcare-facility.change-password');
    Route::get('/healthcare-facility/providers', [HealthcareFacilityController::class, 'providers'])->name('healthcare-facility.providers');
    Route::get('/healthcare-facility/add-new-provider', [HealthcareFacilityController::class, 'addNewProvider'])->name('healthcare-facility.add-new-providers');
    Route::get('/healthcare-facility/edit-provider/{providerID}', [HealthcareFacilityController::class, 'editProvider']);
    Route::post('/healthcare-facility/create-provider', [HealthcareFacilityController::class, 'createProvider'])->name('healthcare-facility.create-provider');
    Route::put('/healthcare-facility/update-provider', [HealthcareFacilityController::class, 'updateProvider'])->name('healthcare-facility.update-provider');
    Route::put('/healthcare-facility/update-image', [HealthcareFacilityController::class, 'updateProfileImage']);
    Route::get('/healthcare-facility/appointment/view/{appointmentID}', [HealthcareFacilityController::class, 'appointment']);
    Route::put('/healthcare-facility/update', [HealthcareFacilityController::class, 'updateHealthcareFacility'])->name('healthcare-facility.update');
    
    
});

Route::post('/healthcare-providers', [PatientController::class, 'getHealthcareProviders']);
Route::post('/healthcare-provider-availability', [PatientController::class, 'getHealthcareProviderAvailability']);


Route::get('about', function () {
    return view('about');
});
