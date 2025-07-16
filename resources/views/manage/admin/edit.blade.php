@extends('layouts.dashboard')

@section('content')
<form method="POST" action="/manage/admin/update/{{ $data->id }}">
    @method('PUT')
    @csrf

    <h2 style="color: black">Edit Admin</h3>
    
    <div class="row mt-3 mb-3" style="color:black">
      <div class="col-md-6 mb-3">
          <label for="full_name" class="col-form-label text-md-end bold">{{ __('Full Name') }}</label>
          <span class="requiredcol">*</span>
            <input id="full_name" style="color: black" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ $data->full_name }}" required autocomplete="full_name" autofocus>
    
            @error('full_name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
      </div>
    
      <div class="col-md-6">
        <label for="email" class="col-form-label text-md-end bold">{{ __('Email') }}</label>
        <span class="requiredcol">*</span>
          <input id="email" type="text" style="color: black" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $data->email }}" required autocomplete="email" autofocus>
    
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