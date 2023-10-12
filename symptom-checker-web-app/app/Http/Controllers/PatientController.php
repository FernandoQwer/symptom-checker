<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


    // Patient Change Password View
    public function predictionResultsView()
    {
        $userID = Auth::user()->id;

        $patient = Patient::where('user_id', $userID)->first();
        $patient->email = Auth::user()->email;

        return view('patient.predictions', compact('patient'));
    }
}
