@extends('layouts.healthcare-facility')

@section('content')
    <h4>Healthcare Facility</h4>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('healthcare-facility.update') }}" id="registerForm">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{ $healthcareFacility->name }}">
                @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" value="{{ $healthcareFacility->contact_email }}">
                @error('email')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mt-3">
                <label for="type" class="form-label">Type</label>

                <select class="form-select" name="type">
                    <option value="hospital" @if($healthcareFacility->type == "hospital") selected @endif>Hospital</option>
                    <option value="healthcare center" @if($healthcareFacility->type == "healthcare center") selected @endif>Healthcare center</option>
                    <option value="nursing home" @if($healthcareFacility->type == "nursing home") selected @endif>Nursing Homes</option>
                    <option value="clinics" @if($healthcareFacility->type == "clinics") selected @endif>Clinics</option>
                </select>
                
                @error('type')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 mt-3">
                <label for="contactNo" class="form-label">Contact No</label>
                <input type="text" class="form-control" name="contactNo" value="{{ $healthcareFacility->contact_phone }}">
                @error('contactNo')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 mt-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3">{{ $healthcareFacility->description }}</textarea>
                @error('description')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 mt-3">
                <label for="addressLineOne" class="form-label">Address Line One</label>
                <input type="text" class="form-control" name="addressLineOne" value="{{ $healthcareFacility['address']->address_line_one }}">
                @error('addressLineOne')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-12 mt-3">
                <label for="addressLineTwo" class="form-label">Address Line Two</label>
                <input type="text" class="form-control" name="addressLineTwo" value="{{ $healthcareFacility['address']->address_line_two }}">
                @error('addressLineTwo')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" name="city" value="{{ $healthcareFacility['address']->city }}">
                @error('city')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mt-3">
                <label for="postalCode" class="form-label">Postal Code</label>
                <input type="text" class="form-control" name="postalCode" value="{{ $healthcareFacility['address']->postal_code }}">
                @error('postalCode')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <button class="btn primary-button" type="submit">Update</button>
        </div>
    </form>
@endsection
