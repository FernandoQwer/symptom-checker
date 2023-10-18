@extends('layouts.patient')

@section('content')
    <h4>Predictions</h4>

    <table class="table table-hover mt-3">
        <thead class="table-primary">
            <tr>
                <th scope="col">Date and Time</th>
                <th scope="col">Symptoms</th>
                <th scope="col">Health Condition (%)</th>
                <th scope="col">Severity<br>Level</th>
                <th scope="col">Appointment</th>
                <th scope="col">Feedback</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($predictions as $prediction)
                <tr>
                    <th scope="row">{{ $prediction->created_at }}</th>
                    <td>
                        @foreach ($prediction->user_symptoms as $userSymptom)
                            <span class="badge text-bg-secondary">{{ $userSymptom->symptom }}</span>
                        @endforeach
                    </td>
                    <td>{{ $prediction->prediction }} ({{ $prediction->score }}%)</td>
                    <td class="text-center">
                        @if ($prediction->severity_level == 'Mild')
                            <span class="text-uppercase badge text-bg-secondary">Mild</span>
                        @elseif ($prediction->severity_level == 'Moderate')
                            <span class="text-uppercase badge text-bg-info">Moderate</span>
                        @elseif ($prediction->severity_level == 'Severe')
                            <span class="text-uppercase badge text-bg-warning">Severe</span>
                        @elseif ($prediction->severity_level == 'Critical')
                            <span class="text-uppercase badge text-bg-danger">Critical</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($prediction->appointment)
                            <a type="button" class="btn btn-primary btn-sm"
                                href="/patient/appointment/view/{{ $prediction->appointment->id }}"><i
                                    class="fa-regular fa-calendar-check"></i> View</a>
                        @else
                            <a type="button" class="btn btn-success btn-sm"
                                href="/patient/add-new-appointment/{{ $prediction->id }}"><i class="fa-solid fa-plus"></i>
                                Add</a>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($prediction->user_feedback)
                            <div class="text-warning" style="font-size: x-small;">
                                @for ($i = $prediction->user_feedback['rating']; $i > 0; $i--)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                                @for ($i = $prediction->user_feedback['rating']; $i < 5; $i++)
                                    <i class="fa-regular fa-star"></i>
                                @endfor
                            </div>
                            <button type="button" class="btn btn-primary btn-sm mt-2"
                                onclick="getUserFeedback({{ $prediction->user_feedback }})"><i
                                    class="fa-regular fa-face-smile"></i> View</button>
                            <button id="userFeedbackViewModalButton" style="display: none;" data-bs-toggle="modal"
                                data-bs-target="#viewUserFeedbackModal"></button>
                        @else
                            <button type="button" class="btn btn-success btn-sm"
                                onclick="newFeedback({{ $prediction->id }})"><i class="fa-solid fa-plus"></i>
                                Add</button>
                            <button id="newFeedbackModalButton" style="display: none;" data-bs-toggle="modal"
                                data-bs-target="#newFeedbackModal"></button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="viewUserFeedbackModal" tabindex="-1" aria-labelledby="viewUserFeedbackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewUserFeedbackModalLabel">User Feedback</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="userFeedbackView">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- New User Feedback -->
    <div class="modal fade" id="newFeedbackModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="newFeedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newFeedbackModalLabel">User Feedback</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="newFeedbackForm">
                        @csrf
                        <div id="formInput">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn primary-button" id="feedbackSubmit">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const userFeedbackViewModalButton = document.getElementById('userFeedbackViewModalButton');
        const newFeedbackModalButton = document.getElementById('newFeedbackModalButton');

        let starRating = 0;
        let predictionID = 0;

        function starCount(rating) {
            $("#inputStars").empty();

            stars = "";
            let s = 1;
            while (s < 6) {
                for (let i = rating; i > 0; i--) {
                    stars += `<i class="fa-solid fa-star" onclick="starCount(${s})"></i>`;

                    s++;
                }

                for (let i = rating; i < 5; i++) {
                    stars += `<i class="fa-regular fa-star" onclick="starCount(${s})"></i>`;
                    s++;
                }
            }

            $("#inputStars").append(stars);

            starRating = rating;
        }

        function newFeedback(prediction) {
            $("#formInput").empty();

            predictionID = prediction;

            let form = `
            <div class="fs-4 text-warning text-center" id="inputStars">
                <i class="fa-regular fa-star" onclick="starCount(1)"></i>
                <i class="fa-regular fa-star" onclick="starCount(2)"></i>
                <i class="fa-regular fa-star" onclick="starCount(3)"></i>
                <i class="fa-regular fa-star" onclick="starCount(4)"></i>
                <i class="fa-regular fa-star" onclick="starCount(5)"></i>
            </div>

            <div class="my-3">
                <label for="commentInput" class="form-label">Comment</label>
                <textarea class="form-control" id="commentInput" rows="3"></textarea>
            </div>  
            `;

            $("#formInput").append(form);

            newFeedbackModalButton.click();
        }

        $("#feedbackSubmit").click(function() {
            let comment = $("#commentInput").val();
            let _token = $('input[name="_token"]').val();

            let formData = {
                'rating': starRating,
                'comment': comment,
                'prediction_id': predictionID
            };

            $.ajax({
                type: "POST",
                url: base_path + "/add-user-feedback",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                success: function(data) {
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });

        function getUserFeedback(userFeedback) {
            $("#userFeedbackView").empty();

            let userFeedbackComment = userFeedback['comment'];

            stars = "";

            for (let i = userFeedback['rating']; i > 0; i--) {
                stars += '<i class="fa-solid fa-star"></i>';
            }

            for (let i = userFeedback['rating']; i < 5; i++) {
                stars += '<i class="fa-regular fa-star"></i>';
            }

            if(userFeedbackComment == null){
                userFeedbackComment = "";
            }

            let userFeedbackView = `
                    <h5 class="text-center text-warning">
                        ${stars}
                    </h5>
                    <h5 class="my-2">Comment</h5>
                    <p>${userFeedbackComment}</p>
            `;

            $("#userFeedbackView").append(userFeedbackView);

            userFeedbackViewModalButton.click();
        }
    </script>
@endsection
