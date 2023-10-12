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
                <li><span>you should providing accurate symptom information</span></li>
                <li><span>it helps differentiate between a common headache and potentially serious conditions</span></li>
                <li><span>remote treatment through our application is suitable for you</span></li>
                <li><span>you should go to see someone in person</span></li>
                <li><span>you should providing accurate symptom information</span></li>
            </ul>
        </div>
    </div>
    <!-- Section Two Ends -->


    <!--Section Three Starts -->
    <div class="row home-section-three">
        <div class="col-md-6 col-12">
            <h3 class="fw-bolder">Frequently asked questions</h3>

            <div class="row mt-4 gx-5">
                <div class="col-12">

                    <span class="fs-6 fw-bold" id="faqOne">
                        <i class="fa-solid fa-plus"></i> How much does the Symptom Checker cost?
                    </span>

                    <p style="display:none;" id="faqOneText">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <hr>

                    <span class="fs-6 fw-bold" id="faqTwo">
                        <i class="fa-solid fa-plus"></i> What are the benefits of using the Symptom Checker?
                    </span>


                    <p style="display:none;" id="faqTwoText">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <hr>

                    <span class="fs-6 fw-bold" id="faqThree">
                        <i class="fa-solid fa-plus"></i> How is this Symptom Checker different from other telemedicine apps?
                    </span>

                    <p style="display:none;" id="faqThreeText">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <hr>
                </div>

            </div>
        </div>

        <div class="col-md-6 col-12 d-flex justify-content-center align-items-center">
            <img src="{{ asset('images/home-section-three-img.png') }}" class="img-fluid" alt="Section Three">
        </div>
    </div>


    <!--Section Three Ends-->

</div>


<script>
    $("#faqOne").click(function() {
        $("#faqOneText").show();
        $("#faqTwoText").hide();
        $("#faqThreeText").hide();
    });

    $("#faqTwo").click(function() {
        $("#faqOneText").hide();
        $("#faqTwoText").show();
        $("#faqThreeText").hide();
    });

    $("#faqThree").click(function() {
        $("#faqOneText").hide();
        $("#faqTwoText").hide();
        $("#faqThreeText").show();
    });
</script>

@endsection