@extends('layouts.app')

@section('content')

<div class="container my-5">
    <div class="row">
        <div class="col-6">
            <label for="symptomInput" class="form-label">Search Symptoms</label>
            <input class="form-control" id="symptomInput" placeholder="Type to search...">
            <ul id="searchResults"></ul>
        </div>
    </div>
 
    <div class="row mt-5">
        <div class="col-4">
            <h5>Symptoms:</h5>

            <ul class="list-group my-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Fever
                    <i class="fa-solid fa-xmark text-danger"></i>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Fever
                    <i class="fa-solid fa-xmark text-danger"></i>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection