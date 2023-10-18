@extends('layouts.healthcare-facility')

@section('content')
    <div class="row justify-content-between">
        <div class="col-10 col-md-6">
            <h4>Healthcare Providers</h4>
        </div>
        <div class="col-2 col-md-6 d-grid  d-md-flex justify-content-md-end">
            <a type="button" class="btn btn-sm primary-button" href="{{ route('healthcare-facility.add-new-providers') }}">Add New Provider</a>
        </div>
    </div>

    <table class="table table-hover mt-4">
        <thead class="table-primary">
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Name</th>
                <th scope="col">Contact Details</th>
                <th scope="col">Speciality</th>
                <th scope="col">Availability</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($providers as $provider)
            <tr>
                <th scope="row">{{ $provider->id }}</th>
                <td>{{ $provider->title }} {{ $provider->first_name }} {{ $provider->last_name }}</td>
                <td>
                    {{ $provider->contact_phone }} <br>
                    {{ $provider->contact_email }}
                </td>
                <td>{{ $provider->specialty  }}</td>
                <td class="font-monospace">
                    @foreach($provider->availability as $availability)
                        {{ $availability->day }} {{ $availability->start_time }} - {{ $availability->end_time }} <br>
                    @endforeach
                </td>
                <td>{{ $provider->status  }}</td>
                <td>
                    <a href="/healthcare-facility/edit-provider/{{ $provider->id }}" class="text-success"><i class="fa-regular fa-pen-to-square"></i></a>
                    {{-- @if($provider->status == "active")
                    <a href="#" class="text-danger"><i class="fa-solid fa-ban"></i></a>
                    @else
                    <a href="#" class="text-danger"><i class="fa-solid fa-unlock"></i></a>
                    @endif --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
