@extends('layouts.header')
@section('content')

<div class="title">
  @if (session()->has('success'))
    <div class="row alert alert-success ml-0 col-12" role="alert">
        {{ session('success') }}
    </div>
  @endif
    @if (session()->has('error'))
    <div class="row alert alert-danger ml-0 col-12" role="alert">
    {{ session('error') }}
    </div>
  @endif
    <div class="title-text">
        <h6>{{ \Carbon\Carbon::parse($data->event_start_at)->format('M j') }}-{{ \Carbon\Carbon::parse($data->event_end_at)->format('j, Y') }}</h6>
        <hr class="small-hr">

        <h1>Lions {{$data->event_name ?? "" }} <br> Indonesia</h1>
        <p>The Lions {{ $data->event_name ?? ""}} is happening 
          
        @if ($data)
            {{-- If $data exists, format its actual start and end dates --}}
            {{ \Carbon\Carbon::parse($data->event_start_at)->format('M j') }}-{{ \Carbon\Carbon::parse($data->event_end_at)->format('j, Y') }}.
        @else
            {{-- If $data does not exist, display today's date range --}}
            {{ \Carbon\Carbon::today()->format('M j') }}-{{ \Carbon\Carbon::today()->format('j, Y') }}.
        @endif
          
          Celebrate service with your fellow <br> Lions and Leos in one of the most unique and exciting travel destinations in the world — beautiful Indonesia!</p>
    </div>
      @if ($registered)
      <button class="btn register-button" href="#">you are already registered, make sure to arrive on time!</button>  
      @else

      @if ($registrationActive)
        @auth
          <button class="btn register-button" onclick="confirmRegistration()">Register Now</button>
              @else
          <a href="{{ route('login') }}">
            <button class="btn register-button">Register Now</button>
          </a>
        @endauth
      @endif
      @endif
</div>

<div class="card-group mt-2">
    <div class="row beneficial-card nopadding">
        <div class="col-sm-4 col-md-3 mt-2">
          <div class="card" style="background: #352068;">
            <div class="card-body">
              <i class="fa-brands fa-connectdevelop fa-5x"></i>
              <h5 class="card-title">Connect with <br> fellow Lions</h5>
            </div>
          </div>
        </div>
        <div class="col-sm-4 col-md-3 mt-2">
          <div class="card" style="background: #006982;">
            <div class="card-body"> 
              <i class="fa-solid fa-map-location-dot fa-5x"></i>
              <h5 class="card-title">Explore <br> Indonesia</h5>
            </div>
          </div>
        </div>
        <div class="col-sm-4 col-md-3 mt-2">
          <div class="card" style="background: #65266D;">
            <div class="card-body">
              <i class="fa-regular fa-lightbulb fa-5x"></i>
              <h5 class="card-title">Get <br> inspired</h5>
            </div>
          </div>
        </div>
        <div class="col-sm-4 col-md-3 mt-2">
          <div class="card w-100" style="background: #002C77;">
            <div class="card-body">
              <i class="fa-solid fa-champagne-glasses fa-5x"></i>
              <h5 class="card-title">Celebrate <br> services</h5>
            </div>
          </div>
        </div>
      </div>
</div>
<div class="description">
    <div class="description-title">
        <h1>Be a part of the biggest Lion event of the year</h1>
        <hr class="small-hr mt-4 mb-5">
    </div>
    <div class="row">
        <div class="col-md-8" style="line-height: 2;">
            <p>Adventure awaits you in Indonesia as the city hosts thousands of Lions and Leos from all over the globe who come together at the premier event of the year. At our Lions {{ $data->event_name ?? "" }}, you’ll celebrate our commitment to serving our world with your fellow Lions and Leos, friends and make new ones.</p>
            <p>Known as the cultural capital of Pontianak, Indonesia offers world-class restaurants and bars, exciting nightlife, eclectic festivals, legendary street art, unique shopping boutiques, incredible beaches and dazzling views, as well as some of the friendliest people you’ll ever meet.</p>
        </div>
        <div class="col-md-4">
            <div class="img-fluid card">
                <div class="card-body">
                  <h5 class="card-title">When</h5>
                  <p class="card-text">{{ \Carbon\Carbon::parse($data->event_start_at)->format('M j') }}-{{ \Carbon\Carbon::parse($data->event_end_at)->format('j, Y') }}</p>
                  <h5 class="card-title">Where</h5>
                  <p class="card-text">Pontianak, Indonesia</p>
                  @if ($registered)
                    <button class="btn register-button" href="#">you are already registered!</button>  
                  @else
                    @if ($registrationActive)
                      <button class="btn register-button"   onclick="confirmRegistration()">Register Now</button>
                    @endif
                  @endif
                </div>
              </div>
        </div>
    </div>
</div>
{{-- <div class="img-fluid d-flex justify-content-center">
    <img src="{{ asset('/storage/content-images/city.webp') }}"  width="90%"/>
</div> --}}

<!-- <div class="event-speakers">
    <div class="speakers-title" align="center">
        <h1>Event speakers</h1>
        <hr class="small-hr mt-3 mb-4">
        <p>Hear from our exciting speakers</p>
    </div>
    <div class="row" align="center">
        <div class="col-md-4 speakers-candidate">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
            class="rounded-circle img-fluid bg-white" style="width: 150px;">
            <h4 class="bold">International President <br> Dr. Patti Hill</h4>
        </div>
        <div class="col-md-4 speakers-candidate">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
            class="rounded-circle img-fluid bg-white" style="width: 150px;">
            <h4 class="bold">LCIF Chairperson <br> Brian Sheehan</h4>
        </div>
        <div class="col-md-4 speakers-candidate">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
            class="rounded-circle img-fluid bg-white" style="width: 150px;">
            <h4 class="bold">First Vice President <br> Fabrício Oliveira</h4>
        </div>
    </div>
</div> -->

<div class="excitement" align="center">
    <div class="row">
        <div class="col-md-3 text-ads" style="background: #352068">
            <h2>See nature at its most beautiful</h2>
        </div>
        <div class="col-md-3 img-ads img-fluid" >
            <img src="https://images.unsplash.com/photo-1501854140801-50d01698950b?auto=format&fit=crop&q=60&w=500&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8bmF0dXJlfGVufDB8fDB8fHww">
        </div>
        <div class="col-md-3 text-ads" style="background: #006982">
            <h2>Explore unique wildlife experiences</h2>
        </div>
        <div class="col-md-3 img-ads img-fluid">
          <img src="https://images.unsplash.com/photo-1535941339077-2dd1c7963098?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHdpbGRsaWZlfGVufDB8fDB8fHww">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 img-ads img-fluid">
            <img src="https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?auto=format&fit=crop&q=60&w=500&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8Y2l0eXxlbnwwfHwwfHx8MA%3D%3D">
        </div>
        <div class="col-md-3 text-ads" style="background: #65266d">
            <h2>Enjoy unforgettable shopping experiences</h2>
        </div>
        <div class="col-md-3 img-ads img-fluid">
            <img src="https://images.unsplash.com/photo-1520500340288-c604ec2d83bd?auto=format&fit=crop&q=60&w=500&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTh8fGRpbmV8ZW58MHx8MHx8fDA%3D" >
        </div>
        <div class="col-md-3 text-ads" style="background: #002c77">
            <h2>Dine on incredible cuisine</h2>
        </div>
    </div>
</div>

@push('body-scripts')
@once
    <script src="{{ asset('js/welcome.js') }}"></script>
@endonce
@endpush

<script>
  function confirmRegistration() {
    const swal = window.Sweetalert2;
    
    swal.fire({
        title: 'Registration Confirmation',
        text: 'Are you sure you want to register for this event?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, register!',
        cancelButtonText: 'No, cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            swal.fire({
                title: 'Processing...',
                text: 'Processing your registration',
                didOpen: () => {
                    swal.showLoading()
                },
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false
            });

            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/register/event';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}
  </script>
@endsection