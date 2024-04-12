@extends('layouts.header')
@section('content')
    
<section style="background-color: #eee;" class="py-2">
    <div class="registration-management">
        <h4>JUNE 21-25, 2024 | MELBOURNE CONVENTION AND EXHIBITION CENTRE</h3>

        <div class="row">
            <div class="col-md-6">
                <a href="/register/create">
                    <button class="btn-reg btn">Individual & Companion/Family Registration</button>
                </a>
                </div>
            <div class="col-md-6">
                <a href="/details/show/{{ auth()->user()->id }}">
                    <button class="btn btn-modify">Modify or Cancel an existing Registration</button>
                </a>
            </div>
        </div>
    </div>
</section>

    @push('additional-styles')
    @once
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    @endonce
    @endpush
@endsection