<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Appointment;
use App\Models\Availability;
use App\Models\HealthcareFacility;
use App\Models\HealthcareProvider;
use App\Models\Patient;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HealthcareFacilityController extends Controller
{

    public function dashboard()
    {
        $userID = Auth::user()->id;

        $healthcareFacility = HealthcareFacility::where('user_id', $userID)->first();
        $healthcareFacility->email = Auth::user()->email;

        $healthcareFacility->address = Address::where('id', $healthcareFacility->address_id)->first();

        return view('healthcare-facility.dashboard',  compact('healthcareFacility'));
    }

    // Update Healthcare Facility
    public function updateHealthcareFacility(Request $request)
    {
        $userID = Auth::user()->id;
        $user = User::where('id', $userID)->first();
        $healthcareFacility = HealthcareFacility::where('user_id', $userID)->first();

        // Validation
        $validated = $request->validate([
            'name' => 'required|max:40',
            'contactNo' => 'required|max:15',
            'description' => 'required',
            'type' => 'required',
            'email' => 'required|email',
            'addressLineOne' => 'required|max:60',
            'addressLineTwo' => 'required|max:60',
            'city' => 'required|max:30',
            'postalCode' => 'required|max:10'
        ]);


        $user->email = $request->email;
        $user->save();

        // Address
        $address = Address::where('id', $healthcareFacility->address_id)->first();
        $address->address_line_one = $request->addressLineOne;
        $address->address_line_two = $request->addressLineTwo;
        $address->city = $request->city;
        $address->postal_code = $request->postalCode;
        $address->timestamps = false;
        $address->save();

        $healthcareFacility->name = $validated['name'];
        $healthcareFacility->description = $validated['description'];
        $healthcareFacility->type = $validated['type'];
        $healthcareFacility->contact_phone = $validated['contactNo'];
        $healthcareFacility->contact_email = $validated['email'];
        $healthcareFacility->save();

        return back()->with('success', 'Updated Successfully!');
    }


    public function providers()
    {
        $userID = Auth::user()->id;

        $healthcareFacility = HealthcareFacility::where('user_id', $userID)->first();
        $healthcareFacility->email = Auth::user()->email;

        $providers = HealthcareProvider::where('healthcare_facility_id', $healthcareFacility->id)->get();

        foreach ($providers as $provider) {
            $availability = Availability::where('healthcare_provider_id', $provider->id)->get();
            $provider->availability = $availability;

            $specialty = Speciality::where('id', $provider->specialty_id)->first()->specialty;
            $provider->specialty = $specialty;
        }

        return view('healthcare-facility.healthcare-providers',  compact('healthcareFacility', 'providers'));
    }

    public function changePasswordView()
    {
        $userID = Auth::user()->id;

        $healthcareFacility = HealthcareFacility::where('user_id', $userID)->first();
        $healthcareFacility->email = Auth::user()->email;

        return view('healthcare-facility.change-password', compact('healthcareFacility'));
    }

    public function addNewProvider()
    {
        $userID = Auth::user()->id;

        $healthcareFacility = HealthcareFacility::where('user_id', $userID)->first();
        $healthcareFacility->email = Auth::user()->email;

        $specialties = Speciality::all();

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return view('healthcare-facility.add-new-healthcare-provider',  compact('healthcareFacility', 'days', 'specialties'));
    }

    public function createProvider(Request $request)
    {
        $userID = Auth::user()->id;
        $healthcareFacility = HealthcareFacility::where('user_id', $userID)->first();

        $validated = $request->validate([
            'firstName' => 'required|max:30',
            'lastName' => 'required|max:30',
            'mobile' => 'required|max:15',
            'email' => 'required|email',
            'specialty' => 'required',
        ]);

        $provider = new HealthcareProvider;
        $provider->title = $request->title;
        $provider->first_name = $request->firstName;
        $provider->last_name = $request->lastName;
        $provider->contact_phone = $request->mobile;
        $provider->contact_email = $request->email;
        $provider->specialty_id = $request->specialty;
        $provider->healthcare_facility_id = $healthcareFacility->id;
        $provider->status = "active";
        $provider->save();

        foreach ($request->days as $day) {
            $startTime = $request->startTime[$day];
            $endTime = $request->endTime[$day];

            $availability = new Availability;
            $availability->day = $day;
            $availability->start_time = $startTime;
            $availability->end_time = $endTime;
            $availability->healthcare_provider_id = $provider->id;
            $availability->save();
        }

        return redirect('/healthcare-facility/providers');
    }


    public function editProvider($providerID)
    {
        $userID = Auth::user()->id;

        $healthcareFacility = HealthcareFacility::where('user_id', $userID)->first();
        $healthcareFacility->email = Auth::user()->email;

        $specialties = Speciality::all();

        $provider = HealthcareProvider::where('id', $providerID)->first();

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        $providerAvailability = Availability::where('healthcare_provider_id', $provider->id)->get();

        return view(
            'healthcare-facility.edit-healthcare-provider',
            compact('healthcareFacility', 'days', 'specialties', 'provider', 'providerAvailability')
        );
    }

    public function updateProvider(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:20',
            'firstName' => 'required|max:30',
            'lastName' => 'required|max:30',
            'mobile' => 'required|max:15',
            'email' => 'required|email',
            'specialty' => 'required',
        ]);


        $provider = HealthcareProvider::where('id', $request->providerID)->first();
        $provider->title = $request->title;
        $provider->first_name = $request->firstName;
        $provider->last_name = $request->lastName;
        $provider->contact_phone = $request->mobile;
        $provider->contact_email = $request->email;
        $provider->specialty_id = $request->specialty;
        $provider->save();

        $currentAvailability = Availability::where('healthcare_provider_id', $request->providerID)
        ->delete();

        foreach ($request->days as $day) {
            $startTime = $request->startTime[$day];
            $endTime = $request->endTime[$day];

            $availability = new Availability;
            $availability->day = $day;
            $availability->start_time = $startTime;
            $availability->end_time = $endTime;
            $availability->healthcare_provider_id = $request->providerID;
            $availability->save();
        }

        return back()->with('success', 'Updated Successfully!');
    }

    // Update Profile Image
    public function updateProfileImage(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $extension = $request->file('image')->getClientOriginalExtension();
        $fileName = rand(1111, 99999) . '.' . $extension;
        $request->file('image')->move(public_path('images/logos/'), $fileName);

        HealthcareFacility::where('user_id', Auth::id())
            ->update(['profile_image' => 'images/logos/' . $fileName]);

        return response()->json("Image Added Successfully!");
    }

    public function appointment($appointmentID)
    {
        $userID = Auth::user()->id;
        $healthcareFacility = HealthcareFacility::where('user_id', $userID)->first();

        $appointment = DB::table('appointments')
            ->join('predictions', 'appointments.prediction_id', '=', 'predictions.id')
            ->select(
                'appointments.*',
                'predictions.prediction',
                'predictions.score',
                'predictions.id as predection_id',
                'predictions.patient_id as patient_id'
            )
            ->where('appointments.id', '=', $appointmentID)
            ->first();

        $patient = Patient::where('id', $appointment->patient_id)->first();

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
                'healthcare_facilities.id as healthcare_facilit_id',
                'healthcare_facilities.contact_phone',
                'addresses.address_line_one',
                'addresses.address_line_two',
                'addresses.city',
                'addresses.postal_code',
                'specialties.specialty'
            )
            ->where('healthcare_providers.id', '=', $appointment->healthcare_provider_id)
            ->first();

        if ($appointment->provider->healthcare_facilit_id != $healthcareFacility->id) {
            return abort(401);
        }

        $appointment->user_symptoms = DB::table('user_symptoms')
            ->join('symptoms', 'user_symptoms.symptom_id', '=', 'symptoms.id')
            ->select('symptoms.symptom')
            ->where('user_symptoms.prediction_id', $appointment->predection_id)
            ->get();

        return view('appointment-view', compact('patient', 'appointment'));
    }

    public function getAppointments()
    {
        $userID = Auth::user()->id;
        $healthcareFacility = HealthcareFacility::where('user_id', $userID)->first();
        $healthcareFacility->email = Auth::user()->email;

        $appointments = DB::table('appointments')
            ->join('healthcare_providers', 'appointments.healthcare_provider_id', '=', 'healthcare_providers.id')
            ->join('specialties', 'healthcare_providers.specialty_id', '=', 'specialties.id')
            ->join('predictions', 'appointments.prediction_id', '=', 'predictions.id')
            ->join('patients', 'predictions.patient_id', '=', 'patients.id')
            ->select(
                'appointments.*',
                'predictions.prediction',
                'predictions.score',
                'patients.first_name as patient_first_name',
                'patients.last_name as patient_last_name',
                'patients.mobile as patient_mobile',
                'healthcare_providers.title as provider_title',
                'healthcare_providers.first_name as provider_first_name',
                'healthcare_providers.last_name as provider_last_name',
                'healthcare_providers.contact_phone as provider_contact_phone',
                'specialties.specialty'
            )
            ->where('healthcare_providers.healthcare_facility_id', '=', $healthcareFacility->id)
            ->get();


        return view('healthcare-facility/appointments', compact('healthcareFacility', 'appointments'));
    }
}
