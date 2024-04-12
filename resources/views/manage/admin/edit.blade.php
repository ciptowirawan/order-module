@extends('layouts.dashboard')

@section('content')
<form method="POST" action="/manage/admin/edit/{{ $data->id }}">
    @method('PUT')
    @csrf
    
    <div class="row mt-3 mb-3" style="color:black">
      <div class="col-md-6 mb-3">
          <label for="first_name" class="col-form-label text-md-end bold">{{ __('First Name') }}</label>
          <span class="requiredcol">*</span>
              <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $data->first_name }}" required autocomplete="first_name" autofocus>
      
              @error('first_name')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
              @enderror
      </div>
    
      <div class="col-md-6">
        <label for="last_name" class="col-form-label text-md-end bold">{{ __('Last Name') }}</label>
        <span class="requiredcol">*</span>
          <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $data->last_name }}" required autocomplete="last_name" autofocus>
    
          @error('last_name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
    
      <div class="col-md-6">
        <label for="email" class="col-form-label text-md-end bold">{{ __('Email') }}</label>
        <span class="requiredcol">*</span>
          <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $data->email }}" required autocomplete="email" autofocus>
    
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>  
    
        <div class="mt-3 btn-block" align="center">
          <div class="col-md-6">
            <button type="submit" style="width:fit-content" class="btn btn-primary">
              Change Admin
            </button>
          </div>
        </div>
      </div>
      
    
    </form>
@endsection