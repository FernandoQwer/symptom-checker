@extends('layouts.app')

@section('content')

<!-- Register Container Starts -->
<div class="row d-flex justify-content-center my-5 g-0">
    <div class="col-12 col-md-8 shadow rounded">
        <div class="row">
            <!-- Register Left Starts -->
            <div class="col-6 d-flex justify-content-center align-items-center">
                <img src="{{ asset('images/register-img.png') }}" class="img-fluid" alt="Register">
            </div>
            <!-- Register Left Ends -->

            <!-- Register Right Starts -->
            <div class="col-6 p-5">
                <h3 class="text-center fw-bold">Register</h3>

                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Register Form Starts -->
                <form method="POST" action="{{ route('patient.register') }}" id="registerForm">
                    @csrf
                    <div class="row g-3 mt-2" id="partOne">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="firstName" value="{{ old('firstName') }}">
                            @error('firstName')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="lastName" value="{{ old('lastName') }}">
                            @error('lastName')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                            @error('email')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}">
                            @error('mobile')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password">
                            @error('password')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                        <div class="col-md-12 d-grid">
                            <button type="button" id="registerFormNext" class="btn primary-button ">Next</button>
                        </div>
                    </div>

                    <div class="row g-3 mt-2" id="partTwo" style="display:none;">
                        <div class="col-md-5">
                            <label for="dateOfBirth" class="form-label">Date Of Birth</label>
                            <input type="date" class="form-control" name="dateOfBirth" value="{{ old('dateOfBirth') }}">
                            @error('dateOfBirth')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-7">
                            <label for="gender" class="form-label">Gender</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male">
                                    <label class="form-check-label" for="radioMale">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female">
                                    <label class="form-check-label" for="radioFemale">Female</label>
                                </div>
                            </div>
                            @error('gender')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="addressLineOne" class="form-label">Address Line One</label>
                            <input type="text" class="form-control" name="addressLineOne" value="{{ old('addressLineOne') }}">
                            @error('addressLineOne')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="addressLineTwo" class="form-label">Address Line Two</label>
                            <input type="text" class="form-control" name="addressLineTwo" value="{{ old('addressLineTwo') }}">
                            @error('addressLineTwo')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" name="city" value="{{ old('city') }}">
                            @error('city')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="postalCode" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" name="postalCode" value="{{ old('postalCode') }}">
                            @error('postalCode')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-2">
                            <input type="checkbox" class="form-check-input" name="termsAndConditions">
                            <label class="form-check-label" for="termsAndConditions">I accepted the Terms and Conditions.</label>
                            @error('termsAndConditions')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 d-grid">
                            <button type="button" id="registerFormBack" class="btn primary-outline-button">Back</button>
                        </div>
                        <div class="col-md-6 d-grid">
                            <button type="submit" class="btn primary-button">Register</button>
                        </div>
                    </div>
                </form>
                <div class="mt-4 text-center">Already have an account? <a href="/login" class="text-decoration-none">Login</a></div>
                <div class="mt-3"><span><i class="fa-solid fa-house-medical"></i></span> Healthcare Facility - <a href="/healthcare-facility-register" class="text-decoration-none">Register</a></div>
                <!-- Register Form Ends -->
            </div>
            <!-- Register Right Ends -->
        </div>
    </div>
</div>
<!-- Register Container Ends -->


<script>
    // Form Next Button
    $("#registerFormNext").click(function() {
        $("#partOne").hide();
        $("#partTwo").show();
    });

    // Form Back Button
    $("#registerFormBack").click(function() {
        $("#partTwo").hide();
        $("#partOne").show();
    });
</script>


@endsection