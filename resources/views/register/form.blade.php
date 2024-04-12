@extends('layouts.header')
@section('content')

<form method="POST" action="/register/store" class="mb-5" style="background-color: #eee;">
    @csrf
    <!-- MultiStep Form -->
    <div class="container-fluid" id="grad1">
        <h4 class="pt-2 dynamic-form-title">Offline Registration</h4>
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0 mb-2">
                <div class="card px-0 px-2 pb-0 mb-3">
                    <div class="row">
                        <div class="col-md-12 mx-0">
                            <!-- progressbar -->
                            <ul id="progressbar" class="d-flex justify-content-center">
                                <li class="active" id="account"><strong>Personal Information</strong></li>
                                <li id="personal"><strong>Account</strong></li>
                                <li id="payment"><strong>Payment</strong></li>
                                {{-- <li id="confirm"><strong>Finish</strong></li> --}}
                            </ul>

                            <h2><strong>Registration</strong></h2>
                            <p>Tell us about yourself</p>

                            @if ($errors->any())
                                <div class="row alert alert-danger ml-0 col-12" role="alert">
                                    <ul class="p-0 m-0 ml-1" style="list-style: square;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- fieldsets -->
                            <fieldset>
                                <div class="text-md-start">
                                    <div class="col-md-12 mb-3">
                                        <label for="registration_type" class="type-title"><span class="requiredcol">*</span>  Registration Type</label>
                                        <div class="form-check">
                                            <input class="form-check-input required-field" type="radio" name="registration_type" id="lion" value="Lion" {{ old("registration_type") == 'Lion' ? "checked" : "" }} required>
                                            <label class="form-check-label" for="lion">
                                            Lion
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="registration_type" id="leo" value="Leo" {{ old("registration_type") == 'Leo' ? "checked" : "" }}>
                                            <label class="form-check-label" for="leo">
                                            Leo
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="registration_type" id="adult" value="Adult Guest" {{ old("registration_type") == 'Adult Guest' ? "checked" : "" }}>
                                            <label class="form-check-label" for="adult">
                                            Adult Guest
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-card row">
                                    <div class="input-header">
                                        <h2 class="fs-title">Personal Information</h2>
                                        <p>Fill out the information below, then click Next to continue.</p>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="full_name" class="type-title"><span class="requiredcol">*</span> Full Name</label>

                                        <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror required-field" name="full_name" value="{{ old('full_name') }}" required autocomplete="full_name">
                    
                                        @error('full_name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="type-title text-md-end bold" for="title">Title (leave blank if none of the below apply)</label>
                                        <div class="input-group">
                                            <select class="form-control form-select @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                                            <option value=""></option>
                                            <option value="Council Chairperson" {{ old("title") == 'Council Chairperson' ? "selected" : "" }}>Council Chairperson</option>

                                            <option value="District Governor" {{ old("title") == 'District Governor' ? "selected" : "" }}>District Governor</option>

                                            <option value="Past Council Chairperson" {{ old("title") == 'Past Council Chairperson' ? "selected" : "" }}>Past Council Chairperson</option>

                                            <option value="Past District Governor" {{ old("title") == 'Past District Governor' ? "selected" : "" }}>Past District Governor</option>

                                            <option value="Region Chairperson" {{ old("title") == 'Region Chairperson' ? "selected" : "" }}>Region Chairperson</option>

                                            <option value="Zone Chairperson" {{ old("title") == 'Zone Chairperson' ? "selected" : "" }}>Zone Chairperson</option>

                                            <option value="Club President" {{ old("title") == 'Club President' ? "selected" : "" }}>Club President</option>

                                            <option value="Club Secretary" {{ old("title") == 'Club Secretary' ? "selected" : "" }}>Club Secretary</option>
                                            </select>
                                        </div>
                                
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="input-subheader">
                                        <h4>Address</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="address_1" class="type-title"><span class="requiredcol">*</span> Address</label>

                                        <input id="address_1" type="text" class="form-control @error('address_1') is-invalid @enderror required-field" name="address_1" value="{{ old('address_1') }}" required autocomplete="address_1">
                    
                                        @error('address_1')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="address_2" class="type-title">Address 2</label>

                                        <input id="address_2" type="text" class="form-control @error('address_2') is-invalid @enderror" name="address_2" value="{{ old('address_2') }}" autocomplete="address_2">
                    
                                        @error('address_2')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="country" class="type-title"><span class="requiredcol">*</span> Country/Region</label>

                                        <div class="input-group">
                                            <select class="form-control form-select @error('country') is-invalid @enderror required-field" id="country" name="country" value="{{ old('country') }}" required>
                                            <option value=""></option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country['name']}}" {{ old("country") == $country['name'] ? "selected" : "" }}>{{$country['name']}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                    
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="city" class="type-title"><span class="requiredcol">*</span> City</label>

                                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror required-field" name="city" value="{{ old('city') }}" required autocomplete="city">
                    
                                        @error('city')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="province" class="type-title"><span class="requiredcol">*</span> State/Province</label>

                                        <input id="province" type="text" class="form-control @error('province') is-invalid @enderror required-field" name="province" value="{{ old('province') }}" required autocomplete="province">
                    
                                        @error('province')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="zip" class="type-title"><span class="requiredcol">*</span> ZIP/Postal Code</label>

                                        <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror required-field" name="zip" value="{{ old('zip') }}" required autocomplete="zip">
                    
                                        @error('zip')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="type-title"><span class="requiredcol">*</span>  Email Address <small>(unique email is required)</small></label>

                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror required-field" name="email" value="{{ old('email') }}" required autocomplete="email">
                    
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone_number" class="type-title"><span class="requiredcol">*</span> Mobile</label>

                                        <div class="row phone-input" >
                                            <div class="col-sm-3">
                                                <select class="form-select @error('phone_code') is-invalid @enderror required-field" id="phone_code" name="phone_code" required>
                                                    <option selected></option>
                                                    @foreach ($countries as $country)
                                                    <option style="font-size: 16px; white-space: pre;" value="{{$country['code']}}" >{{ '(' .$country['code'] . ') '}} &nbsp;&nbsp;&nbsp; {{$country['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror required-field" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number">
                                            </div>
                                        </div>                                     
                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="alternate_phone_number" class="type-title">Alternate Phone</label>
                                        <div class="row phone-input" >
                                            <div class="col-sm-3">
                                                <select class="form-select @error('alternate_phone_code') is-invalid @enderror" id="alternate_phone_code" name="alternate_phone_code">
                                                    <option selected></option>
                                                    @foreach ($countries as $country)
                                                    <option style="font-size: 16px" value="{{$country['code']}}" >{{ '(' .$country['code'] . ') '}} &nbsp;&nbsp;&nbsp; {{$country['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="alternate_phone_number" type="text" class="form-control @error('alternate_phone_number') is-invalid @enderror" name="alternate_phone_number" value="{{ old('alternate_phone_number') }}" autocomplete="alternate_phone_number">

                                            </div>
                                        </div>
                                        @error('alternate_phone_number')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="type-title text-md-end bold" for="district"><span class="requiredcol">*</span> District:</label>
                                        <div class="input-group">
                                            <select class="form-control form-select @error('district') is-invalid @enderror required-field" id="district" name="district" value="{{ old('district') }}" required>
                                            <option value=""></option>
                                            <option value="MD307-A1" {{ old("district") == 'MD307-A1' ? "selected" : "" }}>MD307-A1</option>
                                            <option value="MD307-A2" {{ old("district") == 'MD307-A2' ? "selected" : "" }}>MD307-A2</option>
                                            <option value="MD307-B1" {{ old("district") == 'MD307-B1' ? "selected" : "" }}>MD307-B1</option>
                                            <option value="MD307-B2" {{ old("district") == 'MD307-B2' ? "selected" : "" }}>MD307-B2</option>
                                            </select>
                                        </div>
                                
                                        @error('district')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="club_name" class="type-title">Club Name</label>

                                        <input id="club_name" type="text" class="form-control @error('club_name') is-invalid @enderror" name="club_name" value="{{ old('club_name') }}" autocomplete="club_name">
                    
                                        @error('club_name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="club_number" class="type-title">Club Number</label>

                                        <input id="club_number" type="text" class="form-control @error('club_number') is-invalid @enderror" name="club_number" value="{{ old('club_number') }}" autocomplete="club_number">
                    
                                        @error('club_number')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="emergency_contact" class="type-title"><span class="requiredcol">*</span> Emergency Contact</label>

                                        <input id="emergency_contact" type="text" class="form-control @error('emergency_contact') is-invalid @enderror required-field" name="emergency_contact" value="{{ old('emergency_contact') }}" required autocomplete="emergency_contact">
                    
                                        @error('emergency_contact')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="emergency_phone_number" class="type-title"><span class="requiredcol">*</span> Emergency Contact Phone</label>
                                        <div class="row phone-input" >
                                            <div class="col-sm-3">
                                                <select class="form-select @error('emergency_phone_code') is-invalid @enderror required-field" id="emergency_phone_code" name="emergency_phone_code" required>
                                                    <option selected></option>
                                                    @foreach ($countries as $country)
                                                    <option style="font-size: 16px" value="{{$country['code']}}" >{{ '(' .$country['code'] . ') '}} &nbsp;&nbsp;&nbsp; {{$country['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="emergency_phone_number" type="text" class="form-control @error('emergency_phone_number') is-invalid @enderror required-field" name="emergency_phone_number" value="{{ old('emergency_phone_number') }}" required autocomplete="emergency_phone_number">
                                            </div>
                                        </div>
                    
                                        @error('emergency_phone_number')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-12 conditions">
                                        <label class="type-title text-md-end bold" for="terms"><span class="requiredcol">*</span> Data Protection and Privacy Policy:</label>
                                        <label for="terms" class="type-title">Please note that accepting the data protection and privacy policy is mandatory in order to successfully complete your registration.  For further information on how your data will be used we invite you to carefully read the Data Protection and Privacy Policy and LCI Privacy Policy</label>
                                        <div class="form-check">
                                            <input class="form-check-input shadow required-field" type="checkbox" value="acknowledged" id="acknowledge" name="terms" {{ old("terms") == 'acknowledged' ? "checked" : "" }} required>
                                            <label class="form-check-label" for="acknowledge">
                                                I acknowledge and accept the data protection and privacy policies
                                            </label>
                                          </div>
                                    </div>
                                    <div class="input-header terms">
                                        <h2 class="fs-title">Terms and Conditions</h2>
                                        <p>Take a moment to review the terms and conditions for this event</p>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="type-title text-md-end bold" for="conditions">In order to continue with registration you need to agree to the Terms and Conditions</label>
                                        <div class="form-check">
                                            <input class="form-check-input shadow required-field" type="checkbox" value="agreed" id="agreement" name="conditions" {{ old("conditions") == 'agreed' ? "checked" : "" }} required>
                                            <label class="form-check-label" for="agreement">
                                                <span class="requiredcol">*</span>Yes, I agree to the Terms and Conditions.
                                            </label>
                                          </div>
                                    </div>
                                </div>
                                
                                <input type="button" name="next" class="btn btn-dark next action-button" value="Next Step"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <div class="col-md-12 mb-3">
                                        <label for="password" class="col-form-label text-md-end bold"><span class="requiredcol">*</span> Password</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror required-field" name="password" value="" autocomplete="password" required>
                                        <span style="color: grey">Password must contain at least 8 characters</span>
                                
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                
                                    <div class="col-md-12">
                                        <label for="password-confirm" class="col-form-label text-md-end bold"><span class="requiredcol">*</span> Confirm Password</label>
                                        <input id="password-confirm" type="password" class="form-control @error('password-confirm') is-invalid @enderror required-field" name="password_confirmation" value="" autocomplete="password" required>
                                
                                        @error('password-confirm')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <input type="button" name="previous" class="btn btn-secondary previous action-button-previous" value="Previous"/>
                                <input type="button" name="next" class="btn btn-dark next action-button" value="Next Step"/>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Payment Information</h2>
                                    <div class="radio-group">
                                        <div class='radio' data-value="credit"><img src="https://i.imgur.com/XzOzVHZ.jpg" width="200px" height="100px"></div>
                                        <div class='radio' data-value="paypal"><img src="https://i.imgur.com/jXjwZlj.jpg" width="200px" height="100px"></div>
                                        <br>
                                    </div>
                                    <label class="pay">Card Holder Name*</label>
                                    <input type="text" name="holdername" placeholder=""/>
                                    <div class="row">
                                        <div class="col-9">
                                            <label class="pay">Card Number*</label>
                                            <input type="text" name="cardno" placeholder=""/>
                                        </div>
                                        <div class="col-3">
                                            <label class="pay">CVC*</label>
                                            <input type="password" name="cvcpwd" placeholder="***"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label class="pay">Expiry Date*</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="list-dt" id="month" name="expmonth">
                                                <option selected>Month</option>
                                                <option>January</option>
                                                <option>February</option>
                                                <option>March</option>
                                                <option>April</option>
                                                <option>May</option>
                                                <option>June</option>
                                                <option>July</option>
                                                <option>August</option>
                                                <option>September</option>
                                                <option>October</option>
                                                <option>November</option>
                                                <option>December</option>
                                            </select>
                                            <select class="list-dt" id="year" name="expyear">
                                                <option selected>Year</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                {{-- <input type="button" name="make_payment" class="next action-button" value="Confirm"/> --}}

                                <button type="submit" class="btn text-light bold">
                                    Submit
                                </button>
                            </fieldset>
                            {{-- <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title text-center">Success !</h2>
                                    <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5>You Have Successfully Signed Up</h5>
                                        </div>
                                    </div>
                                </div>
                            </fieldset> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" tabindex="-1" id="unfilledNotice">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Important Notice</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Please fill in all required fields in the current step.</p>
        </div>
        <div class="modal-footer" align="center">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@push('additional-styles')
@once
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endonce
@endpush
@push('body-scripts')
@once
    <script src="{{ asset('js/register.js') }}"></script>
@endonce
@endpush
@endsection