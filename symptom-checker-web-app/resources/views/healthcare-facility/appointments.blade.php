@extends('layouts.healthcare-facility')

@section('content')
    <h4>Patient Appointments</h4>

    <table class="table table-hover mt-4">
        <thead class="table-primary">
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Patient Details</th>
                <th scope="col">Provider Details</th>
                <th scope="col">Prediction</th>
                <th scope="col">Date and Time</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <th scope="row">{{ $appointment->id }}</th>
                    <td>
                        {{ $appointment->patient_first_name }} {{ $appointment->patient_last_name }} <br>
                        {{ $appointment->patient_mobile }}
                    </td>
                    <td>
                        {{ $appointment->provider_title }} {{ $appointment->provider_first_name }}
                        {{ $appointment->provider_last_name }}<br>
                        {{ $appointment->provider_contact_phone }}
                    </td>
                    <td>
                        {{ $appointment->prediction }} <br>
                        {{ $appointment->score }}
                    </td>
                    <td>
                        {{ $appointment->date }} <br>
                        {{ $appointment->start_time }} - {{ $appointment->end_time }}
                    </td>
                    <td>
                        @if ($appointment->status == 'booked')
                            <span class="badge text-bg-info">Confirmed</span>
                        @elseif($appointment->status == 'completed')
                            <span class="badge text-bg-success">Completed</span>
                        @else
                            <span class="badge text-bg-secondary">{{ $appointment->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="/healthcare-facility/appointment/view/{{ $appointment->id }}"><i
                                class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
