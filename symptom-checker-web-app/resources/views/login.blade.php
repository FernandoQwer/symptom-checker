@extends('layouts.app')

@section('content')

<div class="row d-flex justify-content-center my-5 g-0">
    <div class="col-12 col-md-8 shadow rounded">

        <!--Image-->
        <div class="row">
            <div class="col-6 p-5 d-flex justify-content-center align-items-center">
                <img src="{{ asset('images/login-img.png') }}" class="img-fluid" alt="login">
            </div>


            <!--Content Starts-->
            <div class="col-6 d-flex justify-content-center align-items-center">
                <div class="p-4">
                    <h3 class="mb-3 text-center fw-bolder">Login Form</h3>
                    
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('auth.login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
                            @error('email')
                            <div class="form-text text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password">
                            @error('password')
                            <div class="form-text text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn primary-button">Login</button>
                    </form>
                    <br>
                    <p>Don't have an Account? <a href="/register">Register</a></p>
                </div>
            </div>
            <!--Content Ends-->

        </div>
    </div>
</div>



@endsection