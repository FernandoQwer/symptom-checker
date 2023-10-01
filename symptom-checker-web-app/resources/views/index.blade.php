@extends('layouts.app')

@section('content')

<!-- Hero Section Starts -->
<div class="bg-light py-4">
    <div class="container">
        <div class="row gx-5">
            <div class="col-12 col-md-6">
                <div class="home-left">
                    <h1 class="fw-bold lh-base text-primary fs-2">
                        AI-Powered Symptom Checker for Health Conditions
                    </h1>
                    <h3 class="fw-light mt-2 fs-4">AI-Powered Care for a Healthier You</h3>
                    <button type="button" class="btn primary-button mt-3 p-3 rounded-pill">Get Started</button>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <img src="{{ asset('images/home-img.png') }}" alt="Home Image" class="img-fluid rounded mx-auto d-block pulse">
            </div>
        </div>
    </div>
</div>
<!-- Hero Section Ends -->

<div class="container">

    <!-- Section One Starts -->
    <div class="row home-section-one">
        <div class="col-12">
            <h2 class="text-center fw-bolder">Let us take care of you..</h2>
        </div>
        <div class="row mt-5 gx-4">
            <div class="col-4 text-center">
                <h3 class="mb-3">Understand your symptom</h3>
                <i class="fa-solid fa-check section-one-icon"></i>
                <p class="text-primary-emphasis mt-3"> Utilizing AI technology, our symptom checker is offered free of charge</p>
            </div>
            <div class="col-4 text-center">
                <h3 class="mb-3">Manage your health</h3>
                <i class="fa-solid fa-laptop-medical section-one-icon"></i>
                <p class="text-primary-emphasis mt-3">Equipped with our symptom tracker and up-to-date medical information</p>
            </div>
            <div class="col-4 text-center">
                <h3 class="mb-3">Find the care you need</h3>
                <i class="fa-solid fa-heart-pulse section-one-icon"></i>
                <p class="text-primary-emphasis mt-3">Providing personalized care options tailored to your specific symptoms and health profile</p>
            </div>
        </div>
    </div>
    <!-- Section One Ends -->

    <!-- Section Two Starts -->
        <div class="row gx-5 home-section-two">
            <div class="col-md-6 col-12">
                <img src="{{ asset('images/home-section-two-img.png') }}" alt="Section Two Image" width="90%" class="img-fluid mx-auto">
            </div>

            <div class="col-md-6 col-12">
                <h3 class="fw-bolder mt-3">By giving you information, Our Symptom Checker helps you figure out if...</h3>

                <ul class="home-section-two-list mt-5">
                    <li>
                        <span>you should providing accurate symptom information</span>
                    </li>
                    <li><span>it helps differentiate between a common headache and potentially serious conditions</span></li>
                    <li><span>remote treatment through our application is suitable for you</span></li>
                    <li><span>you should go to see someone in person</span></li>
                    <li><span>you should  providing accurate symptom information</span></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Section Two Ends -->

</div>

@endsection