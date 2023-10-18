<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Symptom Checker</title>

    <!-- Bootstrap 5.3.2 -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-5.3.2/bootstrap.min.css') }}">

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Font Awesome 6.4.2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- App Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- jQuery 3.7.1 -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
</head>

<body>
    @include('includes.header')

    <div class="container">
        <div class="row my-5">
            <!-- User Dashboard Menus Starts -->
            <div class="col-md-3 col-12">
                <div class="shadow rounded p-4 mb-4">
                    @if ($healthcareFacility->profile_image != null)
                        <img src="{{ asset($healthcareFacility->profile_image) }}"
                            class="rounded-circle mx-auto d-block img-fluid" style="width: 180px; height:180px;"
                            alt="Profile Avatar">
                    @else
                        <img src="{{ asset('images/logo.jpg') }}" class="rounded-circle mx-auto d-block img-fluid"
                            style="width: 180px; height:180px;" alt="Profile Avatar">
                    @endif

                    <div class="text-center mt-3">
                        <form action="" method="POST" id="imageForm">
                            @csrf
                            @method('PUT')
                            <input type="file" accept="image/*" hidden id="profileImage">
                            <button class="btn btn-sm primary-outline-button" id="profileImageButton" type="submit"><i
                                    class="fa-solid fa-camera"></i> Upload</button>
                        </form>
                    </div>

                    <h5 class="fw-bold text-center mt-4">{{ $healthcareFacility->name }}</h5>
                    <h6 class="text-center">{{ $healthcareFacility->email }}</h6>
                </div>

                <div class="shadow rounded p-4">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="{{ route('healthcare-facility.dashboard') }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('healthcare-facility.providers') }}">Healthcare
                                Providers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"href="{{ route('healthcare-facility.appointments') }}">Patient
                                Appointments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('healthcare-facility.change-password') }}">Change
                                Password</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <form action="{{ route('auth.logout') }}" method="post">
                                @csrf
                                <button type="submit" class="btn"><i class="fa-solid fa-right-from-bracket"></i>Logout</button>
                            </form>
                        </li>
                </div>
            </div>
            <!-- User Dashboard Menus Ends -->

            <div class="col-md-9 col-12">
                <div class="shadow rounded p-4">

                    @yield('content')

                </div>
            </div>
        </div>
    </div>

    <script>
        $("#imageForm").submit(function(e) {
            e.preventDefault();

            let _token = $('input[name="_token"]').val();


            document.getElementById('profileImage').click();

            $('#profileImage').on('change', function() {
                let formData = new FormData();

                var fileInput = document.getElementById('profileImage');

                if (fileInput.files.length > 0) {
                    formData.append('image', fileInput.files[0]);
                }

                formData.append('_token', _token);
                formData.append('_method', 'PUT');

                $.ajax({
                    type: 'POST',
                    url: base_path + "/healthcare-facility/update-image",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': _token
                    },
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>

    @include('includes.footer')
</body>

</html>
