<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SymptomCheckerController extends Controller
{
    
    public function symptomCheckerView()
    {
        return view('symptom-checker');
    }


    public function predict(Request $request)
    {
        //
    }
}
