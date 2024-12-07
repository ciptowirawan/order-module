@extends('layouts.header')
@section('content')

<div class="p-5">
    <div class="btn btn-primary mb-2" color="white">
        <a href="{{ url()->previous() }}" class="text-light text-decoration-none"><i class="fa-solid fa-arrow-left fa-xl"></i>&nbsp;<b>Back</b></a>
    </div>
    @include('dashboard.detail-registrant')
</div>
    
@endsection
