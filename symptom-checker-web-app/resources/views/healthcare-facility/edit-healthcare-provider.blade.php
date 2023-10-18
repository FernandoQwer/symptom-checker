@extends('layouts.healthcare-facility')

@section('content')
    <h4>Add New Provider</h4>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <form class="mt-4" method="POST" action="{{ route('healthcare-facility.update-provider') }}">
        @csrf
        @method('PUT')

        <input type="text" name="providerID" value="{{ $provider->id }}" hidden>

        <div class="row">
            <div class="col-2">
                <label class="mb-2">Title</label>
                <input type="text" class="form-control" name="title" value="{{ $provider->title }}">
                @error('title')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-5">
                <label class="mb-2">First Name</label>
                <input type="text" class="form-control" name="firstName" value="{{ $provider->first_name }}">
                @error('firstName')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-5">
                <label class="mb-2">Last Name</label>
                <input type="text" class="form-control" name="lastName" value="{{ $provider->last_name }}">
                @error('lastName')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-4">
                <label class="mb-2">Mobile</label>
                <input type="text" class="form-control" name="mobile" value="{{ $provider->contact_phone }}">
                @error('mobile')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-4">
                <label class="mb-2">Contact Email</label>
                <input type="email" class="form-control" name="email" value="{{ $provider->contact_email }}">
                @error('email')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-4">
                <label class="mb-2">Speciality</label>
                <select class="form-select" name="specialty">
                    @foreach ($specialties as $specialty)
                        @if ($provider->specialty_id == $specialty->id)
                            <option value="{{ $specialty->id }}" selected>{{ $specialty->specialty }}</option>
                        @else
                            <option value="{{ $specialty->id }}">{{ $specialty->specialty }}</option>
                        @endif
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
                            @php 
                            $checked = false;
                            $startTime = 0;
                            $endTime = 0;
                             @endphp
                            <tr>
                                <th scope="row">
                                    @foreach ($providerAvailability as $availability)
                                        @if ($availability->day == $day)
                                            @php
                                                $checked = true;
                                                $startTime = date("H", strtotime($availability->start_time));
                                                $endTime = date("H", strtotime($availability->end_time));
                                            @endphp
                                        @endif
                                    @endforeach
                                    <input class="form-check-input" type="checkbox" value="{{ $day }}"
                                        name="days[]" @if ($checked) checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ $day }}
                                    </label>
                                </th>
                                <td>
                                    <select class="form-select" aria-label="star time"
                                        name="startTime[{{ $day }}]">
                                        @for ($i = 8; $i < 22; $i++)
                                            <option @if($startTime == $i) selected @endif>{{ $i }}:00</option>
                                        @endfor
                                    </select>
                                </td>
                                <td>
                                    <select class="form-select" aria-label="end time" name="endTime[{{ $day }}]">
                                        @for ($i = 9; $i < 23; $i++)
                                            <option @if($endTime == $i) selected @endif>{{ $i }}:00</option>
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
            <button class="btn primary-button" type="submit">Update</button>
        </div>
    </form>
@endsection
