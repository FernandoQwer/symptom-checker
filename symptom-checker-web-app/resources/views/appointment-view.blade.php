@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row">

            <div class="col-12 col-md-6 p-5">
                <h2 class="text-center fw-bold">Appointment #{{ $appointment->id }}</h2>

                <br>

                <h4 class="fw-bold">Date: <span class="font-monospace">{{ $appointment->date }}</span></h4>
                <h4 class="fw-bold">Time: <span class="font-monospace">{{ $appointment->start_time }}
                        {{ $appointment->end_time }}</span></h4>

                <div class="row mt-4">
                    <h4>Healthcare Provider Details</h4>
                    <hr>
                    <div class="col-12">
                        <h5 class="font-monospace fw-bold"> {{ $appointment->provider->title }}
                            {{ $appointment->provider->first_name }} {{ $appointment->provider->last_name }}
                            ({{ $appointment->provider->specialty }})
                        </h5>
                        <h5 class="fw-bold"><span class="font-monospace">{{ $appointment->provider->name }}<br>
                                {{ $appointment->provider->address_line_one }},
                                {{ $appointment->provider->address_line_two }}, {{ $appointment->provider->city }}
                                <br>{{ $appointment->provider->contact_phone }}
                            </span>
                        </h5>
                    </div>

                </div>

                <div class="row mt-4">
                    <h4>Patient Details</h4>
                    <hr>
                    <h5 class="fw-bold">
                        <span class="font-monospace"> {{ $patient->first_name }} {{ $patient->last_name }} -
                            {{ $patient->mobile }}</span>
                    </h5>

                    <h5 class="mt-2">Prediction</h5>
                    <div>
                        <h5 class="fw-bold font-monospace">{{ $appointment->prediction }} - {{ $appointment->score }}%
                        </h5>
                    </div>

                    <h5 class="mt-2">User Symptoms</h5>
                    <div>
                        @foreach ($appointment->user_symptoms as $userSymptom)
                            <span class="fw-bold font-monospace fs-5">'{{ $userSymptom->symptom }}' </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
                <img src="{{ asset('images/side-img.png') }}" class="img-fluid" alt="side image">
            </div>
        </div>

    </div>
@endsection
