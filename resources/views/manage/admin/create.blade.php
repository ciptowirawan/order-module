@extends('layouts.dashboard')

@section('content')
<form method="POST" action="/manage/admin/store">    
    @csrf

    <h2 style="color: black">Tambahkan Admin</h3>
    
    <div class="row mt-3 mb-3" style="color:black">
      <div class="col-md-6 mb-3">
          <label for="full_name" class="col-form-label text-md-end bold">{{ __('Full Name') }}</label>
          <span class="requiredcol">*</span>
            <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" required autocomplete="full_name" autofocus>
    
            @error('full_name')
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

        <div class="col-md-12 my-3">
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