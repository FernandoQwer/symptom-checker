@extends('layouts.patient')

@section('content')

<h4>User Profile</h4>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- User Profile Details Starts -->
<form class="mt-4" method="POST" action="{{ route('patient.update') }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-6">
            <label class="mb-2">First Name</label>
            <input type="text" class="form-control" name="first_name" value="{{ $patient->first_name }}">
            @error('first_name')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-6">
            <label class="mb-2">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="{{ $patient->last_name }}">
            @error('last_name')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-6 mt-3">
            <label class="mb-2">Mobile</label>
            <input type="text" class="form-control" name="mobile" value="{{ $patient->mobile }}">
            @error('mobile')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-3 mt-3">
            <label class="mb-2">Date of Birth</label>
            <input type="date" class="form-control" name="dob" value="{{ $patient->dob }}">
            @error('dob')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-3 mt-3">
            <label class="mb-2">Gender</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male" @if($patient->gender == "male") checked @endif>
                    <label class="form-check-label" for="radioMale">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female" @if($patient->gender == "female") checked @endif>
                    <label class="form-check-label" for="radioFemale">Female</label>
                </div>
            </div>
            @error('gender')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <hr class="mt-5">

    <div class="row">
        <h5 class="my-3">User Address Details</h5>

        <div class="col-6 mb-3">
            <label class="mb-2">Address Line One</label>
            <input type="text" class="form-control" name="address_line_one" value="{{ $patient->address_line_one }}">
            @error('address_line_one')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-6 mb-3">
            <label class="mb-2">Address Line Two</label>
            <input type="text" class="form-control" name="address_line_two" value="{{ $patient->address_line_two }}">
            @error('address_line_two')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-6 mb-3">
            <label class="mb-2">City</label>
            <input type="text" class="form-control" name="city" value="{{ $patient->city }}">
            @error('city')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-6 mb-3">
            <label class="mb-2">Postal Code</label>
            <input type="text" class="form-control" name="postal_code" value="{{ $patient->postal_code }}">
            @error('postal_code')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2">
        <button class="btn primary-button" type="submit">Update</button>
    </div>
</form>
<!-- User Profile Details Ends -->

@endsection