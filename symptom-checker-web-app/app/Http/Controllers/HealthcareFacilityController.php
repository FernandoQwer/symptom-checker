<?php

namespace App\Http\Controllers;

use App\Models\HealthcareFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HealthcareFacilityController extends Controller
{
    
    public function dashboard()
    {
        $userID = Auth::user()->id;

        $healthcareFacility = HealthcareFacility::where('user_id', $userID)->first();
        $healthcareFacility->email = Auth::user()->email;


        return view('healthcare-facility.dashboard',  compact('healthcareFacility'));
    }

}
