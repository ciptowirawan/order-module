@extends('layouts.header')
@section('content')

<form method="POST" id="form" action="/register/update/{{$member->id}}" class="mb-5 p-3" style="background-color: #eee;">
    @method('PUT')
    @csrf
    <!-- MultiStep Form -->
    <div class="container-fluid" id="grad1">    
        <div class="row justify-content-center m-3">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0 mb-2">
                <div class="card px-0 px-2 pb-0 mb-3">
                    <div class="row">
                        <div class="col-md-12 p-5">

                            <h2><strong>Edit</strong></h2>
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

                                <div class="form-card row">
                                    <div class="input-header">
                                        <h2 class="fs-title">Personal Information</h2>
                                        <p>Fill out the information below, then click Next to continue.</p>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <label class="type-title text-md-end bold" for="title">Title (leave blank if none of the below apply)</label>
                                        <div class="input-group">
                                            <select class="form-control form-select @error('title') is-invalid @enderror" id="title" name="title" value="{{ $member->title }}">
                                            <option value=""></option>
                                            @foreach ($titles as $title)
                                            {{-- <option value="{{ $title->title_name }}" {{ $member->title == $title->title_name ? "selected" : "" }}>{{$title->title_name}}</option> --}}
                                            <option value="{{ $title }}" {{ $member->title == $title ? "selected" : "" }}>
                                                {{ $title }}
                                            </option>
                                            @endforeach
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

                                        <input id="address_1" type="text" class="form-control @error('address_1') is-invalid @enderror required-field" name="address_1" value="{{ $member->address_1 }}" autocomplete="address_1">
                    
                                        @error('address_1')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="address_2" class="type-title">Address 2</label>

                                        <input id="address_2" type="text" class="form-control @error('address_2') is-invalid @enderror" name="address_2" value="{{ $member->address_2 }}" autocomplete="address_2">
                    
                                        @error('address_2')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="country" class="type-title"><span class="requiredcol">*</span> Country/Region</label>

                                        <div class="input-group">
                                            <select class="form-control form-select @error('country') is-invalid @enderror required-field" id="country" name="country" value="{{ $member->country }}" required 
                                            >
                                            <option value=""></option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country['name']}}" {{ $member->country == $country['name'] ? "selected" : "" }}>{{$country['name']}}</option>
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

                                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror required-field" name="city" value="{{ $member->city }}" required autocomplete="city">
                    
                                        @error('city')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="province" class="type-title"><span class="requiredcol">*</span> State/Province</label>

                                        <input id="province" type="text" class="form-control @error('province') is-invalid @enderror required-field" name="province" value="{{ $member->province }}" required autocomplete="province">
                    
                                        @error('province')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="zip" class="type-title"><span class="requiredcol">*</span> ZIP/Postal Code</label>

                                        <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror required-field" name="zip" value="{{ $member->zip }}" autocomplete="zip">
                    
                                        @error('zip')
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
                                                    <option style="font-size: 16px; white-space: pre;" value="{{$country['code']}}" {{ $memberCountryCode == $country['code'] ? "selected" : "" }} >{{ '(' .$country['code'] . ') '}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror required-field" name="phone_number" value="{{ $member->phone_number }}" required autocomplete="phone_number">
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
                                                    <option style="font-size: 16px" value="{{$country['code']}}" {{ $memberCountryCode == $country['code'] ? "selected" : "" }}>{{ '(' .$country['code'] . ') '}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="alternate_phone_number" type="text" class="form-control @error('alternate_phone_number') is-invalid @enderror" name="alternate_phone_number" value="{{ $member->alternate_phone_number}}" autocomplete="alternate_phone_number">

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
                                            <select class="form-control form-select @error('district') is-invalid @enderror required-field" id="district" name="district" value="{{ $member->district }}" required>
                                            <option value=""></option>
                                            <option value="MD307-A1" {{ $member->district == 'MD307-A1' ? "selected" : "" }}>MD307-A1</option>
                                            <option value="MD307-A2" {{ $member->district == 'MD307-A2' ? "selected" : "" }}>MD307-A2</option>
                                            <option value="MD307-B1" {{ $member->district == 'MD307-B1' ? "selected" : "" }}>MD307-B1</option>
                                            <option value="MD307-B2" {{ $member->district == 'MD307-B2' ? "selected" : "" }}>MD307-B2</option>
                                            <option value="Others" {{ $member->district == 'Others' ? "selected" : "" }}>Others</option>
                                            </select>
                                        </div>
                                
                                        @error('district')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label for="club_name" class="type-title">Club Name</label>

                                        <input id="club_name" type="text" class="form-control @error('club_name') is-invalid @enderror" name="club_name" value="{{ $member->club_name }}" autocomplete="club_name">
                    
                                        @error('club_name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                <div class="row justify-content-center">
                                    <button type="submit" class="btn text-light bold">
                                        Submit
                                    </button>
                                </div>

                            </fieldset>
                        </div>
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
    <script src="{{ asset('js/edit.js') }}"></script>
@endonce
@endpush
@endsection