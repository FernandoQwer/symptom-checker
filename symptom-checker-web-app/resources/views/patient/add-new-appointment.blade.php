@extends('layouts.app')

@section('content')
    <div class="row d-flex justify-content-center my-5 g-0">
        <div class="col-12 col-md-8 shadow rounded p-5">
            <h3 class="text-center my-4">Schedule an Appointment</h3>
            <hr>

            <div class="row">
                <div class="col-12 col-md-2 fw-bold">
                    Health Condition
                </div>
                <div class="col-12 col-md-4">
                    {{ $prediction->prediction }}
                </div>
                <div class="col-12 col-md-2 fw-bold">
                    Probability
                </div>
                <div class="col-12 col-md-4">
                    {{ $prediction->score }}%
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 col-md-2 fw-bold">
                    User Symptoms
                </div>
                <div class="col-12 col-md-10">
                    @foreach ($prediction->user_symptoms as $userSymptom)
                        <span class="badge text-bg-secondary">{{ $userSymptom->symptom }}</span>
                    @endforeach
                </div>
            </div>

            <hr>

            <div class="row mt-2">
                <div class="col-12 col-md-2 fw-bold mt-md-2">
                    Speciality
                </div>
                <div class="col-12 col-md-4 mt-2">
                    <select class="form-select" name="specialty" id="specialty">
                        <option value="0">Select a Speciality</option>

                        @foreach ($prediction->health_professionals as $specialty)
                            <option value="{{ $specialty->id }}">{{ $specialty->specialty }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2 fw-bold">
                    Health Professionals
                </div>
                <div class="col-12 col-md-4 mt-2">
                    <select class="form-select" name="healthProfessional" id="healthProfessional">
                        <option value="0">Select a Health Professional</option>


                    </select>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12 col-md-2 fw-bold mt-md-2">
                    Date
                </div>
                <div class="col-12 col-md-4 mt-2">
                    <input type="text" class="form-control" name="appointmentDate" id="appointmentDate">
                </div>
                <div class="col-12 col-md-2 fw-bold mt-md-2">
                    Time Slot
                </div>
                <div class="col-12 col-md-4 mt-2">
                    <select class="form-select" name="timeSlot" id="timeSlot">
                        <option value="0">Select a Time Slot</option>
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <form method="POST" action="{{ route('patient.new-appointment') }}" id="appointmentForm">
                    @csrf

                    <div class="row">
                        <div class="mb-3 mt-3">
                            <label for="notes" class="form-label fw-bold">Notes</label>
                            <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button class="btn primary-button" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        let specialty = $("#specialty").val();

        $("#appointmentDate").datepicker({
            minDate: 1
        });

        let defaultHealthProfessional = `<option value="0">Select a Health Professional</option>`;
        let defaultTimeSlot = `<option value="0">Select a Time Slot</option>`;

        // Default State
        function defaultInputState() {
            $("#healthProfessional").empty();
            $("#healthProfessional").append(defaultHealthProfessional);

            $("#timeSlot").empty();
            $("#timeSlot").append(defaultTimeSlot);

            $("#healthProfessional").attr("disabled", true);
            $("#appointmentDate").attr("disabled", true);
            $("#timeSlot").attr("disabled", true);
        }

        if (specialty == 0) {
            defaultInputState();
        }

        $(document).ready(function() {
            let _token = $('input[name="_token"]').val();

            $("#specialty").on("change", function() {
                specialty = $("#specialty").val();
                if (specialty > 0) {

                    let specialtyData = {
                        'specialty': specialty
                    };

                    $.ajax({
                        type: "POST",
                        url: base_path + "/healthcare-providers",
                        data: specialtyData,
                        headers: {
                            'X-CSRF-TOKEN': _token
                        },
                        success: function(data) {
                            $("#healthProfessional").empty();
                            $("#healthProfessional").append(defaultHealthProfessional);

                            $.each(data, function(key, value) {
                                let healthProfessionalOption =
                                    `<option value="${value.id}">${value.title} ${value.first_name} ${value.last_name}</option>`;
                                // console.log(value.first_name);
                                $("#healthProfessional").append(
                                    healthProfessionalOption);

                            });

                            $("#healthProfessional").attr("disabled", false);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });

                } else {
                    defaultInputState();
                }
            });

            $("#healthProfessional").on("change", function() {
                $("#appointmentDate").empty();

                $("#timeSlot").empty();
                $("#timeSlot").append(defaultTimeSlot);

                healthProfessional = $("#healthProfessional").val();
                if (healthProfessional > 0) {
                    $("#appointmentDate").attr("disabled", false);
                } else {
                    $("#appointmentDate").attr("disabled", true);
                    $("#timeSlot").attr("disabled", true);
                }
            });

            $("#appointmentDate").on("change", function() {
                $("#timeSlot").empty();
                $("#timeSlot").append(defaultTimeSlot);

                appointmentDate = $("#appointmentDate").datepicker("getDate");
                let dayOfWeek = appointmentDate.toLocaleDateString(undefined, {
                    weekday: 'long'
                });

                let date = new Date(appointmentDate);

                let day = date.getDate();
                let month = date.getMonth() + 1;
                let year = date.getFullYear();
                let dateOnly = `${year}-${month}-${day}`;

                let appointmentDateData = {
                    'day': dayOfWeek,
                    'date': dateOnly,
                    'provider_id': $("#healthProfessional").val()
                };

                $.ajax({
                    type: "POST",
                    url: base_path + "/healthcare-provider-availability",
                    data: appointmentDateData,
                    headers: {
                        'X-CSRF-TOKEN': _token
                    },
                    success: function(data) {
                        console.log(data);
                        let dateAvailability = data['dateAvailability'];

                        $("#timeSlot").empty();
                        $("#timeSlot").append(defaultTimeSlot);

                        let startTime = data['availability'].start_time;
                        let endTime = data['availability'].end_time;

                        while (startTime < endTime) {
                            let timeParts = startTime.split(":");
                            let date = new Date();
                            date.setHours(parseInt(timeParts[0], 10));
                            date.setMinutes(parseInt(timeParts[1], 10));
                            date.setSeconds(parseInt(timeParts[2], 10));

                            date.setMinutes(date.getMinutes() + 10);

                            let newStartTime = date.toLocaleTimeString('en-US', {
                                hour12: false
                            });

                            let timeSlotOption =
                                `<option value="${startTime} - ${newStartTime}">${startTime} - ${newStartTime}</option>`;


                            $.each(dateAvailability, function(key, value) {
                                if (value.start_time == startTime) {
                                    timeSlotOption = "";
                                }
                            });

                            $("#timeSlot").append(timeSlotOption);


                            startTime = newStartTime;
                        }

                        $("#timeSlot").attr("disabled", false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });

            });

            $("#appointmentForm").submit(function(e) {
                e.preventDefault();

                let timeRange = $("#timeSlot").val();
                let provider = $("#healthProfessional").val();

                if(
                    timeRange == '' || timeRange == 0 ||
                    provider == '' || provider == 0
                ){
                    console.log("Error");
                }

                appointmentDate = $("#appointmentDate").datepicker("getDate");
                let date = new Date(appointmentDate);

                let day = date.getDate();
                let month = date.getMonth() + 1;
                let year = date.getFullYear();
                let dateOnly = `${year}-${month}-${day}`;

                let times = timeRange.split(" - ");
                let startTime = times[0];
                let endTime = times[1];

                let notes = $("#notes").val();

                let formData = {
                    'date': dateOnly,
                    'start_time': startTime,
                    'end_time': endTime,
                    'healthcare_provider_id': provider,
                    'notes': notes,
                    'prediction_id': {{ $prediction->id }}
                };


                $.ajax({
                    type: "POST",
                    url: base_path + "/patient/create-an-appointment",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': _token
                    },
                    success: function(data) {
                        window.location.href = base_path + "/patient/appointments";
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });

        });
    </script>
@endsection
