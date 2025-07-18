@extends('layouts.dashboard')

@section('content')
<form method="POST" action="/manage/events/update/{{ $data->id }}">
    @method('PUT')
    @csrf

    <h2 style="color: black">Edit Event</h3>
    
      <div class="row mt-3 mb-3" style="color:black">
      <div class="col-md-6 mb-3">
          <label for="event_name" class="col-form-label text-md-end bold">{{ __('Event Name') }}</label>
          <span class="requiredcol">*</span>
            <input id="event_name" style="color: black" type="text" class="form-control @error('event_name') is-invalid @enderror" name="event_name" value="{{ $data->event_name }}" required autocomplete="event_name" autofocus>
    
            @error('event_name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
      </div>
    
      <div class="col-md-12">
        <label for="registration_start_at" class="col-form-label text-md-end bold">{{ __('Registration Start At') }}</label>
        <span class="requiredcol">*</span>
          <input id="registration_start_at" style="color: black" type="date" class="form-control @error('registration_start_at') is-invalid @enderror" name="registration_start_at" value="{{ $data->registration_start_at }}" required autocomplete="registration_start_at" autofocus>
    
            @error('registration_start_at')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>  

        <div class="col-md-12">
        <label for="registration_end_at" class="col-form-label text-md-end bold">{{ __('Registration End At') }}</label>
        <span class="requiredcol">*</span>
          <input id="registration_end_at" style="color: black" type="date" class="form-control @error('registration_end_at') is-invalid @enderror" name="registration_end_at" value="{{ $data->registration_end_at }}" required autocomplete="registration_end_at" autofocus>
    
            @error('registration_end_at')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>  

        <div class="col-md-12">
        <label for="event_start_at" class="col-form-label text-md-end bold">{{ __('Event Start At') }}</label>
        <span class="requiredcol">*</span>
          <input id="event_start_at" style="color: black" type="date" class="form-control @error('event_start_at') is-invalid @enderror" name="event_start_at" value="{{ $data->event_start_at }}" required autocomplete="event_start_at" autofocus>
    
            @error('event_start_at')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>  

        <div class="col-md-12">
        <label for="event_end_at" class="col-form-label text-md-end bold">{{ __('Event end At') }}</label>
        <span class="requiredcol">*</span>
          <input id="event_end_at" type="date" class="form-control @error('event_end_at') is-invalid @enderror" name="event_end_at" style="color: black" value="{{ $data->event_end_at }}" required autocomplete="event_end_at" autofocus>
    
            @error('event_end_at')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>  
    
        <div class="mt-3 btn-block" align="center">
          <div class="col-md-6">
            <button type="submit" style="width:fit-content" class="btn btn-primary">
              Change Event
            </button>
          </div>
        </div>
      </div>
      
    
    </form>
@endsection