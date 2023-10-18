<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Appointment;
use App\Models\Availability;
use App\Models\HealthcareProvider;
use App\Models\HealthCondition;
use App\Models\Patient;
use App\Models\Prediction;
use App\Models\User;
use App\Models\UserFeedback;
use App\Models\UserSymptom;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    // Update Profile Image
    public function updateProfileImage(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $extension = $request->file('image')->getClientOriginalExtension();
        $fileName = rand(1111, 99999) . '.' . $extension;
        $request->file('image')->move(public_path('images/profile-images/'), $fileName);

        Patient::where('user_id', Auth::id())
            ->update(['profile_image' => 'images/profile-images/'.$fileName]);

        return response()->json("Image Added Successfully!");
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
            ->where('predictions.patient_id', $patient->id)
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
            ->select('specialties.*')
            ->where('health_condition_specialties.health_condition_id', '=', $prediction->health_condition_id)
            ->get();

        $prediction->health_professionals = $healthProfessionals;

        return view('patient.add-new-appointment', compact('prediction'));
    }

    public function addNewAppointment(Request $request)
    {
        $predictionID = 0;

        $patientID = Patient::where('user_id', Auth::user()->id)->first()->id;
        $prediction = Prediction::where('id', $predictionID)->first();

        $appointment = new Appointment;
        $appointment->date = $request->date;
        $appointment->start_time = $request->startTime;
        $appointment->end_time = $request->endTime;
        $appointment->healthcare_provider_id = $request->healthcareProviderID;
        $appointment->prediction_id = $prediction->id;
        $appointment->notes = $request->notes;
        $appointment->status = "Booked";
        $appointment->save();

        return redirect('/patient/appointments');
    }

    public function appointmentsView()
    {
        $userID = Auth::user()->id;

        $patient = Patient::where('user_id', $userID)->first();
        $patient->email = Auth::user()->email;

        $appointments = DB::table('appointments')
            ->join('predictions', 'appointments.prediction_id', '=', 'predictions.id')
            ->select('appointments.*', 'predictions.prediction', 'predictions.score')
            ->where('predictions.patient_id', '=', $patient->id)
            ->get();

        foreach ($appointments as $appointment) {
            $provider = DB::table('healthcare_providers')
                ->join('healthcare_facilities', 'healthcare_providers.healthcare_facility_id', '=', 'healthcare_facilities.id')
                ->join('addresses', 'healthcare_facilities.address_id', '=', 'addresses.id')
                ->select(
                    'healthcare_providers.title',
                    'healthcare_providers.first_name',
                    'healthcare_providers.last_name',
                    'healthcare_facilities.name',
                    'healthcare_facilities.contact_phone',
                    'addresses.city'
                )
                ->where('healthcare_providers.id', '=', $appointment->healthcare_provider_id)
                ->first();

            $appointment->provider = $provider;
        }

        return view('patient.appointments', compact('patient', 'appointments'));
    }

    public function appointment($appointmentID)
    {
        $userID = Auth::user()->id;
        $patient = Patient::where('user_id', $userID)->first();

        $appointment = DB::table('appointments')
            ->join('predictions', 'appointments.prediction_id', '=', 'predictions.id')
            ->select('appointments.*', 'predictions.prediction', 'predictions.score', 'predictions.id as predection_id')
            ->where('predictions.patient_id', '=', $patient->id)
            ->where('appointments.id', '=', $appointmentID)
            ->first();

        if (!$appointment) {
            return abort(401);
        }

        $appointment->provider = DB::table('healthcare_providers')
            ->join('healthcare_facilities', 'healthcare_providers.healthcare_facility_id', '=', 'healthcare_facilities.id')
            ->join('addresses', 'healthcare_facilities.address_id', '=', 'addresses.id')
            ->join('specialties', 'healthcare_providers.specialty_id', '=', 'specialties.id')
            ->select(
                'healthcare_providers.title',
                'healthcare_providers.first_name',
                'healthcare_providers.last_name',
                'healthcare_facilities.name',
                'healthcare_facilities.contact_phone',
                'addresses.address_line_one',
                'addresses.address_line_two',
                'addresses.city',
                'addresses.postal_code',
                'specialties.specialty'
            )
            ->where('healthcare_providers.id', '=', $appointment->healthcare_provider_id)
            ->first();


        $appointment->user_symptoms = DB::table('user_symptoms')
            ->join('symptoms', 'user_symptoms.symptom_id', '=', 'symptoms.id')
            ->select('symptoms.symptom')
            ->where('user_symptoms.prediction_id', $appointment->predection_id)
            ->get();

        return view('appointment-view', compact('patient', 'appointment'));
    }


    public function createAppointment(Request $request)
    {

        $appointment = new Appointment;
        $appointment->date = $request->date;
        $appointment->start_time = $request->start_time;
        $appointment->end_time = $request->end_time;
        $appointment->healthcare_provider_id = $request->healthcare_provider_id;
        $appointment->prediction_id = $request->prediction_id;
        $appointment->notes = $request->notes;
        $appointment->status = "booked";
        $appointment->save();

        return response()->json("Appointment Added Successfully!");
    }


    public function getHealthcareProviders(Request $request)
    {
        $specialty = $request->specialty;

        $healthProfessionals = HealthcareProvider::where('specialty_id', $specialty)->get();

        return response()->json($healthProfessionals);
    }

    public function getHealthcareProviderAvailability(Request $request)
    {

        $day = $request->day;
        $date = $request->date;
        $healthcareProviderID = $request->provider_id;

        $availability = Availability::where('day', $day)
            ->where('healthcare_provider_id', $healthcareProviderID)->first();


        $dateAvailability = Appointment::where('date', $date)->get();

        $data['availability'] =  $availability;
        $data['dateAvailability'] =  $dateAvailability;

        return response()->json($data);
    }

    public function newUserFeedback(Request $request)
    {
        $predictionID = $request->prediction_id;
        $comment = $request->comment;
        $rating = $request->rating;

        $userFeedback = new UserFeedback;
        $userFeedback->prediction_id = $predictionID;
        $userFeedback->comment = $comment;
        $userFeedback->rating = $rating;
        $userFeedback->save();

        return response()->json("User Feedback Added Successfully!");
    }
}
