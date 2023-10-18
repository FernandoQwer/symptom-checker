@extends('layouts.patient')

@section('content')
    <h4>Appointments</h4>

    <table class="table table-hover mt-4">
        <thead class="table-primary">
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Date and Time</th>
                <th scope="col">Provider Details</th>
                <th scope="col">Prediction</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <th scope="row">{{ $appointment->id }}</th>
                <td>
                    {{ $appointment->date }}
                    <br>
                    {{ $appointment->start_time }} - {{ $appointment->end_time }}
                </td>
                <td>
                    {{ $appointment->provider->title }} {{ $appointment->provider->first_name }} {{ $appointment->provider->last_name }} <br>
                    {{ $appointment->provider->name }} - {{ $appointment->provider->city }}
                    {{ $appointment->provider->contact_phone }}
                </td>
                <td>
                    {{ $appointment->prediction }} <br> ({{ $appointment->score }}%)
                </td>
                <td>
                    @if($appointment->status == "booked")
                        <span class="badge text-bg-info">Confirmed</span>
                    @elseif($appointment->status == "completed")
                        <span class="badge text-bg-success">Completed</span>
                    @else
                        <span class="badge text-bg-secondary">{{ $appointment->status }}</span>
                    @endif
                </td>
                <td>
                    <a type="button" class="btn btn-primary btn-sm" href="/patient/appointment/view/{{ $appointment->id }}">
                        <i class="fa-regular fa-calendar-check"></i> View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
