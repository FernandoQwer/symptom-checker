@extends('layouts.patient')

@section('content')

<h4>Predictions</h4>

<table class="table table-hover mt-3">
    <thead class="table-primary">
      <tr>
        <th scope="col">Date and Time</th>
        <th scope="col">Symptoms</th>
        <th scope="col">Health Condition (%)</th>
        <th scope="col">Severity<br>Level</th>
        <th scope="col">Appointment</th>
        <th scope="col">Feedback</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <th scope="row">2023/09/04<br>11.00 PM</th>
        <td>
            <span class="badge text-bg-secondary">Headache</span>
            <span class="badge text-bg-secondary">Numbness</span>
        </td>
        <td>Migraine (78%)</td>
        <td class="text-center">
            <span class="badge text-bg-warning">Mid</span>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-primary btn-sm"><i class="fa-regular fa-calendar-check"></i> View</button>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i> Add</button>
        </td>
      </tr>

      <tr>
        <th scope="row">2023/09/01<br>10.00 AM</th>
        <td>
            <span class="badge text-bg-secondary">Coughing</span>
            <span class="badge text-bg-secondary">Watery eyes</span>
            <span class="badge text-bg-secondary">Fever</span>
        </td>
        <td>Cold (90%)</td>
        <td class="text-center">
            <span class="badge text-bg-success">Low</span>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i> Add</button>
        </td>
        <td class="text-center">
            <div class="text-warning" style="font-size: x-small;">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
            </div>
            <button type="button" class="btn btn-primary btn-sm mt-2"><i class="fa-regular fa-face-smile"></i> View</button>
        </td>
      </tr>

    </tbody>
  </table>



@endsection