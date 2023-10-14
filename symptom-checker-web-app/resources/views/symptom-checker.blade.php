@extends('layouts.app')

@section('content')

<div class="container my-5">
    <div class="row">
        <h2>Symptom Checker</h2>

        <div class="col-12 col-md-6">
            <!-- Symptoms Starts -->
            <div class="row mt-3" id="symptoms">
                <div class="row">
                    <div class="col-12 mt-3">
                        <label for="symptomInput" class="form-label fs-4 fw-bold">Search Symptoms</label>
                        <input class="form-control" id="symptomInput" placeholder="Type to search...">
                        <ul id="searchResults"></ul>
                    </div>
                </div>

                <div class="row mt-4">
                    <h4 class="fw-bold">Symptoms</h4>
                    <div class="col-6">
                        <ul class="list-group my-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Fever
                                <i class="fa-solid fa-xmark text-danger"></i>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Fever
                                <i class="fa-solid fa-xmark text-danger"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 mt-3">
                        <form method="post" id="predictForm">
                            @csrf
                            <div class="d-grid d-md-flex justify-content-md-end">
                                <button type="submit" class="btn primary-button px-5 py-2" id="predict">Predict</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Symptoms Ends -->

            <!-- Prediction Starts -->
            <div class="row mt-3" id="prediction" style="display:none;">
                <h4 class="fw-bold">Prediction</h4>

                <h2 class="fw-bold text-center text-uppercase mt-4" id="condition"></h2>
                <h2 class="fw-bolder text-center text-uppercase fs-1"><span id="score"></span>%</h2>
                <h3 class="text-center fs-6 fw-light">(Predicton Score)</h3>

                <h3 class="mt-3 fs-6">
                    <span class="fw-bold">Severity Level:</span>
                    <span id="severityLevel"></span>
                </h3>

                <div class="mt-2">
                    <h3 class="fs-6 fw-bold">Description:</h3>
                    <p id="description"></p>
                </div>

                <div class="mt-2">
                    <h3 class="fs-6 fw-bold">Health Professionals:</h3>
                    <ul id="healthProfessionals">
                    </ul>
                </div>

                <hr>

                <div class="mt-2">
                    <h6>
                        <span class="fw-bold">User Input Symptoms: </span><span id="userSymptoms"></span>
                    </h6>
                    <h6>
                        <span class="fw-bold">Predicted Date and Time: </span> <span id="dateAndTime"></span>
                    </h6>
                </div>
                <hr>
                <div class="mt-3">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-secondary me-md-2" type="button" id="retake">Retake</button>
                        @auth
                        <a class="btn primary-button" type="button" id="appointmentButton">Schedule an Appointment</a>
                        @endauth
                    </div>
                </div>
                @guest
                <div class="my-3">
                    <h6 class="text-primary">To schedule an appointment, kindly sign in to your account.</h6>
                </div>
                @endguest
            </div>
            <!-- Prediction Ends -->
        </div>

        <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
            <img src="{{ asset('images/side-img.png') }}" class="img-fluid" alt="side image">
        </div>
    </div>

</div>

<script>


    $("#predictForm").submit(function(e) {
        e.preventDefault();

        let _token = $('input[name="_token"]').val();

        let userSymptoms = {
            'user_symptoms': ['skin_rash', 'itching']
        };

        $.ajax({
            type: "POST",
            url: "http://localhost:8000/predict",
            data: userSymptoms,
            headers: {
                'X-CSRF-TOKEN': _token
            },
            success: function(data) {
                console.log(data);

                let severity;
                let healthProfessionals = "";
                let userSymptoms = "";

                // Severity Level
                if (data.severity_level == "Mild") {
                    severity = `<span class="text-uppercase badge text-bg-secondary">Mild</span>`;
                } else if (data.severity_level == "Moderate") {
                    severity = `<span class="text-uppercase badge text-bg-info">Moderate</span>`;
                } else if (data.severity_level == "Severe") {
                    severity = `<span class="text-uppercase badge text-bg-warning">Severe</span>`;
                } else if (data.severity_level == "Critical") {
                    severity = `<span class="text-uppercase badge text-bg-danger">Critical</span>`;
                }


                // Health Professionals
                data['health_professionals'].forEach((item, index) => {
                    healthProfessionals += `<li>${item.specialty}</li>\n`;
                });

                // User Symptoms
                data['user_input_symptoms'].forEach((item, index) => {
                    userSymptoms += `${item} | `;
                });

                $("#condition").append(data.condition);
                $("#score").append(data.predicted_probability);
                $("#severityLevel").append(severity);
                $("#description").append(data.description);
                $("#healthProfessionals").append(healthProfessionals);
                $("#dateAndTime").append(data.date_and_time);
                $("#userSymptoms").append(userSymptoms);

                let appointmentURL = `/patient/add-new-appointment/${data.id}`;
                $("#appointmentButton").attr("href", appointmentURL);
                
                $("#symptoms").hide();
                $("#prediction").show();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
</script>

@endsection