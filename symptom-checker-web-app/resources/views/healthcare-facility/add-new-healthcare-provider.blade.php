@extends('layouts.healthcare-facility')

@section('content')
    <h4>Add New Provider</h4>

    <form class="mt-4" method="POST" action="{{ route('healthcare-facility.create-provider') }}">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-2">
                <label class="mb-2">Title</label>
                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                @error('title')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-5">
                <label class="mb-2">First Name</label>
                <input type="text" class="form-control" name="firstName" value="{{ old('firstName') }}">
                @error('firstName')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-5">
                <label class="mb-2">Last Name</label>
                <input type="text" class="form-control" name="lastName" value="{{ old('lastName') }}">
                @error('lastName')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-4">
                <label class="mb-2">Mobile</label>
                <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}">
                @error('mobile')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-4">
                <label class="mb-2">Contact Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-4">
                <label class="mb-2">Speciality</label>
                <select class="form-select" name="specialty" value="{{ old('specialty') }}">
                    @foreach($specialties as $specialty)
                    <option value="{{ $specialty->id }}">{{ $specialty->specialty }}</option>
                    @endforeach
                </select>
                @error('specialty')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <hr class="mt-4">

        <h5>Availability</h5>

        <div class="row">
            <div class="col-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Day</th>
                            <th scope="col">Start Time</th>
                            <th scope="col">End Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($days as $day)
                            <tr>
                                <th scope="row">
                                    <input class="form-check-input" type="checkbox" value="{{ $day }}" name="days[]">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ $day }}
                                    </label>
                                </th>
                                <td>
                                    <select class="form-select" aria-label="star time" name="startTime[{{ $day }}]">
                                        @for ($i = 8; $i < 22; $i++)
                                            <option>{{ $i }}:00</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <select class="form-select" aria-label="end time" name="endTime[{{ $day }}]">
                                        @for ($i = 9; $i < 23; $i++)
                                            <option>{{ $i }}:00</option>
                                        @endfor
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <button class="btn primary-button" type="submit">Create</button>
        </div>
    </form>
    
@endsection
