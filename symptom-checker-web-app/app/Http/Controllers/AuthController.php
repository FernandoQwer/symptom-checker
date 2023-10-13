<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Patient;
use App\Models\HealthcareFacility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // User Login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // LogIn User
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role'      => "patient",
            'is_active' => TRUE
        ])) {
            $request->session()->regenerate();
            return redirect('/patient/dashboard')->with('status', 'Login Successfully!');
        }

        return back()->with('error', 'Invalid Credentials!');
    }


    // User Register
    public function patientRegister(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'firstName' => 'required|max:30',
            'lastName' => 'required|max:30',
            'mobile' => 'required|max:15',
            'gender' => 'required|max:8',
            'dateOfBirth' => 'required|date',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'addressLineOne' => 'required|max:60',
            'addressLineTwo' => 'required|max:60',
            'city' => 'required|max:30',
            'postalCode' => 'required|max:10',
            'termsAndConditions' => 'required'
        ]);

        // Password Hashing
        $password = Hash::make($request->password);

        // New User
        $user = new User;
        $user->email = $request->email;
        $user->password = $password;
        $user->role = "patient";
        $user->is_active = TRUE;
        $user->save();

        // Address
        $address = new Address;
        $address->address_line_one = $request->addressLineOne;
        $address->address_line_two = $request->addressLineTwo;
        $address->city = $request->city;
        $address->postal_code = $request->postalCode;
        $address->timestamps = false;
        $address->save();

        // Patient Details
        $patient = new Patient;
        $patient->first_name = $request->firstName;
        $patient->last_name = $request->lastName;
        $patient->gender = $request->gender;
        $patient->mobile = $request->mobile;
        $patient->dob = $request->dateOfBirth;
        $patient->user_id = $user->id;
        $patient->address_id = $address->id;
        $patient->save();

        // LogIn User
        if (Auth::attempt([
            'email' => $user->email,
            'password' => $request->password,
            'role'      => "patient",
            'is_active' => TRUE
        ])) {
            $request->session()->regenerate();
            return redirect('/patient/dashboard');
        }

        return back()->with('error', 'Something Went Wrong!');
    }

    // Healthcare Facility Register
    public function healthcareFacilityRegister(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name' => 'required|max:40',
            'contactNo' => 'required|max:15',
            'description' => 'required',
            'type' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'addressLineOne' => 'required|max:60',
            'addressLineTwo' => 'required|max:60',
            'city' => 'required|max:30',
            'postalCode' => 'required|max:10',
            'termsAndConditions' => 'required'
        ]);

        // Password Hashing
        $password = Hash::make($request->password);

        // New User
        $user = new User;
        $user->email = $request->email;
        $user->password = $password;
        $user->role = "facility";
        $user->is_active = TRUE;
        $user->save();

        // Address
        $address = new Address;
        $address->address_line_one = $request->addressLineOne;
        $address->address_line_two = $request->addressLineTwo;
        $address->city = $request->city;
        $address->postal_code = $request->postalCode;
        $address->timestamps = false;
        $address->save();

        $healthcareFacility = new HealthcareFacility;
        $healthcareFacility->name = $validated['name'];
        $healthcareFacility->description = $validated['description'];
        $healthcareFacility->type = $validated['type'];
        $healthcareFacility->contact_phone = $validated['contactNo'];
        $healthcareFacility->contact_email = $validated['email'];
        $healthcareFacility->user_id = $user->id;
        $healthcareFacility->address_id = $address->id;
        $healthcareFacility->save();

        // LogIn User
        if (Auth::attempt([
            'email' => $user->email,
            'password' => $request->password,
            'role'      => "facility",
            'is_active' => TRUE
        ])) {
            $request->session()->regenerate();
            return redirect('/healthcare-facility/dashboard');
        }

        return back()->with('error', 'Something Went Wrong!');
    }


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
