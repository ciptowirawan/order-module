@extends('layouts.header')
@section('content')

<div class="title">
    <div class="title-text">
        <h1>Individual Registration</h1>
        <p>Find all the information you need about registration costs and secure your spot in Melbourne today!</p>
    </div>
</div>

<div class="info-content">
    <div class="pricing-rates">
        <h1>Explore pricing rates</h1>
        <hr class="small-hr">
    
        <div class="pricing-button">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="reg-card-content">
                                <h5 class="card-title bold">Early Bird</h5>
                                <p>Through January 12, <br> 2024</p>
                                <hr class="card-hr">

                                <h2 class="bold">US$190</h2>
                                <a href="/register" class="btn register-button">Register</a>
                            </div>
                        </div>
                      </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="reg-card-content">
                                <h5 class="card-title bold">Regular</h5>
                                <p>January 13 – June 16,<br> 2024</p>
                                <hr class="card-hr">

                                <h2 class="bold">US$265</h2>
                                <a href="/register" class="btn register-button">Register</a>
                            </div>
                        </div>
                      </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="reg-card-content">
                                <h5 class="card-title bold">Onsite</h5>
                                <p>June 17 – June 25, 2024</p>
                                <hr class="card-hr">

                                <h2 class="bold">US$190</h2>
                                <a href="/register" class="btn register-button">Register</a>
                            </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
        <p class="my-3"><i>Prices do not include lodging costs.</i></p>
    
    </div>

    <div class="hr-info">
        <h1>Modify or cancel your registration</h1>
        <hr class="small-hr">

        <p>If you need to modify or cancel your convention registration, housing and event tickets, it must be done online by May 1, 2024 to receive a full refund less a $25 processing fee. No exceptions will be made after this date.</p>
    </div>

    <div class="answers-info">
        <h1>Get the answers you need</h1>
        <hr class="small-hr">

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <img src="https://img.freepik.com/free-vector/organic-flat-people-asking-questions-illustration_23-2148906283.jpg?size=626&ext=jpg" alt="" class="img-fluid">
                      <h5 class="card-title">General questions</h5>
                      <p class="card-text">For general questions about the convention, please email us at <br> <a href="">md-307@club.org.</a></p>
                    </div>
                  </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <img src="https://img.freepik.com/free-vector/building-concept-illustration_114360-4469.jpg?size=626&ext=jpg" alt="" class="img-fluid">
                        <h5 class="card-title">Registration and hotels</h5>
                        <p class="card-text">For questions about registration and hotels, including group registration, contact us by phone at <b>866-268-0198 (US & Canada)</b> or <b>972-349-5436 (International)</b>. You can also email us<br> at <a href="">lci@mcievents.com.</a></p>
                    </div>
                  </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <img src="https://img.freepik.com/free-vector/illustration-document-icon_53876-28510.jpg?size=626&ext=jpg" alt="" class="img-fluid">
                        <h5 class="card-title">Terms and conditions</h5>
                        <p class="card-text">For detailed information about registration and housing, check out the LionsCon Registration and Housing <a href="">Terms and Conditions.</a></p>
                    </div>
                  </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <img src="https://img.freepik.com/free-vector/appointment-booking-with-smartphone_23-2148578379.jpg?size=626&ext=jpg" alt="" class="img-fluid">
                        <h5 class="card-title">Additional payment options</h5>
                        <p class="card-text">To pay by check or wire transfer, please complete <a href="">this form</a> and view the <a href="">JP Morgan Chase Bank instructions</a> for additional information.</p>
                    </div>
                  </div>
            </div>
        </div>

    </div>
</div>


    
@push('additional-styles')
    @once
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    @endonce
    @endpush
@endsection