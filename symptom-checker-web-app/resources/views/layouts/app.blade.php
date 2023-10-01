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

        @yield('content')

        @include('includes.footer')
    </body>
</html>
