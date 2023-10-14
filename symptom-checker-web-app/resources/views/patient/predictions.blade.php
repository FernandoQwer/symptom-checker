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
    @foreach($predictions as $prediction)
    <tr>
      <th scope="row">{{ $prediction->created_at }}</th>
      <td>
        @foreach($prediction->user_symptoms as $userSymptom)
        <span class="badge text-bg-secondary">{{ $userSymptom->symptom }}</span>
        @endforeach
      </td>
      <td>{{ $prediction->prediction }} ({{ $prediction->score }}%)</td>
      <td class="text-center">
        @if($prediction->severity_level == "Mild")
        <span class="text-uppercase badge text-bg-secondary">Mild</span>
        @elseif ($prediction->severity_level == "Moderate")
        <span class="text-uppercase badge text-bg-info">Moderate</span>
        @elseif ($prediction->severity_level == "Severe")
        <span class="text-uppercase badge text-bg-warning">Severe</span>
        @elseif ($prediction->severity_level == "Critical")
        <span class="text-uppercase badge text-bg-danger">Critical</span>
        @endif
      </td>
      <td class="text-center">
        @if($prediction->appointment)
        <button type="button" class="btn btn-primary btn-sm"><i class="fa-regular fa-calendar-check"></i> View</button>
        @else
        <button type="button" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i> Add</button>
        @endif
      </td>
      <td class="text-center">
        @if($prediction->user_feedback)
        <div class="text-warning" style="font-size: x-small;">
          @for($i=$prediction->user_feedback['rating']; $i > 0; $i--)
            <i class="fa-solid fa-star"></i>
          @endfor
          @for($i=$prediction->user_feedback['rating']; $i < 5; $i++)
            <i class="fa-regular fa-star"></i>
          @endfor
        </div>
        <button type="button" class="btn btn-primary btn-sm mt-2"><i class="fa-regular fa-face-smile"></i> View</button>
        @else
        <button type="button" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i> Add</button>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>



@endsection