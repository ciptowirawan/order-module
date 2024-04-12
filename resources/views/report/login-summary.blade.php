@extends('layouts.dashboard')

@section('content')

<h1 class="h3 mb-2 text-gray-800">Most Active Users</h1>

<form action="/reports/login-summary" method="get" class="d-sm-inline-block form-inline mr-auto ml-md-12 my-2 my-md-0 w-100">
    <div class="input-group">
        <input type="text" class="form-control bg-light border-1 small"
        name="search" aria-label="Search" aria-describedby="basic-addon2" value="{{ request('search') }}">
        <div class="input-group-append">
        <button class="btn" style="z-index: 0; background-color: #4c076b" type="submit">
            <i class="fas fa-search fa-sm" style="color: white"></i>
        </button>
        </div>
    </div>
</form>

@if ($registrations->count())
<div class="table-responsive mt-2">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 5%">No. </th>
                <th>User Name</th>
                <th style="width: 30%">Login Attempts</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $registration)
            <tr>
                <td align="center">{{ $loop->iteration + $registrations->firstItem() - 1 }}</td>
                <td>{{ $registration->user_name }}</td>
                <td>{{ $registration->login_attempts }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else 
    <p class="text-center my-4 fs-4">Peserta Tidak Ditemukan.</p>   
@endif

<div class="d-flex justify-content-center" >
    {{ $registrations->links() }}
</div>

@endsection