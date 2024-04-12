@extends('layouts.dashboard')

@section('content')
<form method="POST" action="/manage/admin/store">    
    @csrf

    <h2 style="color: black">Add New Admin</h3>
    
    <div class="row mt-3 mb-3" style="color:black">
      <div class="col-md-6 mb-3">
          <label for="first_name" class="col-form-label text-md-end bold">{{ __('First Name') }}</label>
          <span class="requiredcol">*</span>
              <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
      
              @error('first_name')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
              @enderror
      </div>
    
      <div class="col-md-6">
        <label for="last_name" class="col-form-label text-md-end bold">{{ __('Last Name') }}</label>
        <span class="requiredcol">*</span>
          <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
    
          @error('last_name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
    
      <div class="col-md-12">
        <label for="email" class="col-form-label text-md-end bold">{{ __('Email') }}</label>
        <span class="requiredcol">*</span>
          <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
    
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>  

        <div class="col-md-12 mb-3">
            <label for="password" class="col-form-label text-md-end bold"><span class="requiredcol">*</span> Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="" autocomplete="password">
    
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    
        <div class="col-md-12">
            <label for="password-confirm" class="col-form-label text-md-end bold"><span class="requiredcol">*</span> Confirm Password</label>
            <input id="password-confirm" type="password" class="form-control @error('password-confirm') is-invalid @enderror" name="password_confirmation" value="" autocomplete="password">
    
            @error('password-confirm')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>        
    
        <div class="mt-3 btn-block" align="center">
          <div class="col-md-6">
            <button type="submit" style="width:fit-content" class="btn btn-primary">
              Submit
            </button>
          </div>
        </div>
      </div>
      
    
    </form>
@endsection