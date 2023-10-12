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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                    <img src="{{ asset('images/Avatar.jpg') }}" class="rounded-circle mx-auto d-block img-fluid" style="width: 180px;" alt="Profile Avatar">
                    
                    <div>
                        <input type="file" accept="image*" hidden>
                        <i class="fa-solid fa-camera"></i>
                    </div>
                    <h5 class="fw-bold text-center mt-4">{{ $patient->first_name." ".$patient->last_name }}</h5>
                    <h6 class="text-center">{{ $patient->email }}</h6>
                </div>

                <div class="shadow rounded p-4">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('patient.dashboard') }}">User Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.predictions') }}">Predictions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Appointments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.change-password') }}">Change Password</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
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

    @include('includes.footer')
</body>

</html>