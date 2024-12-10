@extends('layouts.dashboard')

@section('content')

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

<h1 class="h3 mb-2 text-gray-800">Pilih Event</h1>

@if($events->count() > 0)
<div class="row">
    @foreach($events as $event)
    <div class="col-md-12">
        <div class="card w-100">
        <div class="card-body">
            <h5 class="card-title">{{$event->event_name}}</h5>
            <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
            @if($purpose == "1") 
                <a href="/dashboard/participants/event/{{$event->id}}" class="btn btn-primary">See Details</a>
            @endif
            @if($purpose == "2") 
                <a href="/dashboard/presence-unattended/event/{{$event->id}}" class="btn btn-primary">See Details</a>
            @endif
            @if($purpose == "3") 
                <a href="/dashboard/presence-attended/event/{{$event->id}}" class="btn btn-primary">See Details</a>
            @endif
        </div>
        </div>
    </div>
    @endforeach
</div>

@else

<p class="text-center my-4 fs-4">Anggota Tidak Ditemukan.</p>    
@endif

@endsection