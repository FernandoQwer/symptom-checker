<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Appointment;
use App\Models\HealthCondition;
use App\Models\Patient;
use App\Models\Prediction;
use App\Models\User;
use App\Models\UserFeedback;
use App\Models\UserSymptom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function patientDashboard()
    {
        $userID = Auth::user()->id;

        $patient = Patient::where('user_id', $userID)->first();
        $patient->email = Auth::user()->email;

        $address = Address::where('id', $patient->address_id)->first();

        $patient->address_line_one = $address->address_line_one;
        $patient->address_line_two = $address->address_line_two;
        $patient->city = $address->city;
        $patient->postal_code = $address->postal_code;

        return view('patient.dashboard', compact('patient'));
    }

    // Patient Update Profile and Address
    public function updatePatient(Request $request)
    {
        $userID = Auth::user()->id;

        $validated = $request->validate([
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'mobile' => 'required|max:15',
            'gender' => 'required|max:8',
            'dob' => 'required|date',
            'address_line_one' => 'required|max:60',
            'address_line_two' => 'required|max:60',
            'city' => 'required|max:30',
            'postal_code' => 'required|max:10',
        ]);

        $patient = Patient::where('user_id', $userID)->first();
        // Update Patient 
        $patient->update($validated);

        $address = Address::where('id', $patient->address_id)->first();
        // Update Address
        $address->address_line_one = $request->address_line_one;
        $address->address_line_two = $request->address_line_two;
        $address->city = $request->city;
        $address->postal_code = $request->postal_code;
        $address->timestamps = false;
        $address->save();

        return back()->with('success', 'Patient Profile Updated Successfully!');
    }

    // Patient Change Password View
    public function changePasswordView()
    {
        $userID = Auth::user()->id;

        $patient = Patient::where('user_id', $userID)->first();
        $patient->email = Auth::user()->email;

        return view('patient.change-password', compact('patient'));
    }

    // Patient Change Password
    public function updatePassword(Request $request)
    {
        $userID = Auth::user()->id;

        $validated = $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $password = Hash::make($request->password);

        $user = User::find($userID);
        $user->password = $password;
        $user->save();

        return back()->with('success', 'Password Updated Successfully!');
    }



    public function predictionResultsView()
    {
        $userID = Auth::user()->id;

        $patient = Patient::where('user_id', $userID)->first();
        $patient->email = Auth::user()->email;

        $predictions = DB::table('predictions')
            ->join('health_conditions', 'predictions.health_condition_id', '=', 'health_conditions.id')
            ->select('predictions.*', 'health_conditions.severity_level')
            ->get();

        foreach ($predictions as $prediction) {
            $prediction->user_feedback = UserFeedback::where('prediction_id', $prediction->id)->first();

            $prediction->appointment = Appointment::where('prediction_id', $prediction->id)->first();

            $prediction->user_symptoms = DB::table('user_symptoms')
                ->join('symptoms', 'user_symptoms.symptom_id', '=', 'symptoms.id')
                ->select('symptoms.symptom')
                ->where('user_symptoms.prediction_id', $prediction->id)
                ->get();
        }

        return view('patient.predictions', compact('patient', 'predictions'));
    }


    public function newAppointmentPage($predictionID)
    {
        $patientID = Patient::where('user_id', Auth::user()->id)->first()->id;
        $prediction = Prediction::where('id', $predictionID)->first();
        $appointment = Appointment::where('prediction_id', $prediction->id)->first();

        if ($patientID != $prediction->patient_id || $appointment) {
            return abort(401);
        }

        $prediction->user_symptoms = DB::table('user_symptoms')
            ->join('symptoms', 'user_symptoms.symptom_id', '=', 'symptoms.id')
            ->select('symptoms.symptom')
            ->where('user_symptoms.prediction_id', $prediction->id)
            ->get();

        $healthProfessionals = DB::table('health_condition_specialties')
            ->join('specialties', 'health_condition_specialties.speciality_id', '=', 'specialties.id')
            ->select('specialties.specialty')
            ->where('health_condition_specialties.health_condition_id', '=', $prediction->health_condition_id)
            ->get();

        $prediction->health_professionals = $healthProfessionals;

        return view('patient.add-new-appointment', compact('prediction'));
    }
}
