<?php

namespace App\Http\Controllers;

use App\Models\HealthCondition;
use App\Models\Patient;
use App\Models\Prediction;
use App\Models\Symptom;
use App\Models\UserSymptom;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SymptomCheckerController extends Controller
{

    public function symptomCheckerView()
    {
        $symptoms = Symptom::orderBy('symptom', 'asc')->get();;

        return view('symptom-checker', compact('symptoms'));
    }


    public function predict(Request $request)
    {

        $url = '127.0.0.1:5000/symptom-checker';

        $userSymptoms = array();

        foreach($request->user_symptoms as $userSymptom){
            $symptom = Symptom::where('symptom', $userSymptom)->first()->symptom_key;
            $userSymptoms[] = $symptom;
        }

        $response = Http::post($url, ['user_symptoms' =>  $userSymptoms]);

        $healthCondition = HealthCondition::where('condition', $response['health_condition'])->first();

        $prediction = $healthCondition;
        $prediction->predicted_probability = $response['predicted_probability'];

        $healthProfessionals = DB::table('health_condition_specialties')
            ->join('specialties', 'health_condition_specialties.speciality_id', '=', 'specialties.id')
            ->select('specialties.specialty')
            ->where('health_condition_specialties.health_condition_id', '=', $healthCondition->id)
            ->get();

        $prediction->health_professionals = $healthProfessionals;
        $prediction->date_and_time = now()->format('Y-m-d H:i:s');

        // User Symptoms
        $symptoms = array();

        // Patient
        if (Auth::check() && Auth::user()->role == "patient") {
            $patientID = Patient::where('user_id', Auth::id())->first()->id;

            $userPrediction = new Prediction;
            $userPrediction->prediction = $response['health_condition'];
            $userPrediction->score = $response['predicted_probability'];
            $userPrediction->patient_id = $patientID;
            $userPrediction->health_condition_id = $prediction->id;
            $userPrediction->save();

            $prediction->id = $userPrediction->id;

            foreach ($userSymptoms as $userInputSymptom) {
                $symptom = Symptom::where('symptom_key', $userInputSymptom)->first();

                $userSymptom = new UserSymptom;
                $userSymptom->prediction_id = $userPrediction->id;
                $userSymptom->symptom_id = $symptom->id;
                $userSymptom->save();

                $symptoms[] = $symptom->symptom;
            }

            $dateAndTime = Carbon::parse($userPrediction->created_at)->format('Y-m-d H:i:s');
            $prediction->date_and_time = $dateAndTime;
        } else {
            $prediction->id = 0;

            foreach ($userSymptoms as $userSymptom) {
                $symptom = Symptom::where('symptom_key', $userSymptom)->first()->symptom;
                $symptoms[] = $symptom;
            }
        }

        $prediction->user_input_symptoms = $symptoms;

        return response()->json($prediction);
    }
}
