@extends('layouts.patient')

@section('content')

<h4>Change Password</h4>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Change Password Starts -->
<form class="mt-4" method="POST" action="{{ route('patient.update-password') }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-6">
            <label class="mb-2">New Password</label>
            <input type="password" class="form-control" name="password">
            @error('password')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-6">
            <label class="mb-2">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
        <button class="btn primary-button" type="submit">Update</button>
    </div>
</form>
<!-- Change Password Ends -->


@endsection