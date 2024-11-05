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

<h1 class="h3 mb-2 text-gray-800">Daftar Anggota <span class="badge badge-success">Active</span></h1>

<form action="/manage/paid" method="get" class="d-sm-inline-block form-inline mr-auto ml-md-12 my-2 my-md-0 w-100">
    <div class="input-group">
        <input type="text" class="form-control bg-light border-1 small" placeholder="Cari Peserta..."
        name="search" aria-label="Search" aria-describedby="basic-addon2" value="{{ request('search') }}">
        <div class="input-group-append">
        <button class="btn btn-primary" style="z-index: 0" type="submit">
            <i class="fas fa-search fa-sm"></i>
        </button>
        </div>
    </div>
</form>

<div class="row mx-1 my-3 justify-content-between">
    <div class="d-flex justify-content-start">
        {{-- <a href="{{ route('export-paid-pdf') }}" class="btn btn-danger w-100"><b>Download as Pdf</b>&nbsp;<i class="fa-solid fa-file-pdf"></i></a> --}}
        <div class="dropdown">
            <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                <b>Export as Pdf By District</b>&nbsp;<i class="fa-solid fa-file-pdf"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-start">
                <a class="dropdown-item" href="{{ route('export-paid-pdf') }}">All District</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('export-paid-pdf-by-district', 'MD307-A1') }}">MD307-A1</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('export-paid-pdf-by-district', 'MD307-A2') }}">MD307-A2</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('export-paid-pdf-by-district', 'MD307-B1') }}">MD307-B1</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('export-paid-pdf-by-district', 'MD307-B2') }}">MD307-B2</a>
            </div>
          </div>
    </div>        
    <div class="d-flex justify-content-end mr-1">
        @if (request()->route('district'))
            <a href="/manage/paid" class="btn btn-danger mr-2">
                Cancel Sorting
            </a>
        @endif
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                Sort By District
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('sortByDistrict', 'MD307-A1') }}">MD307-A1</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('sortByDistrict', 'MD307-A2') }}">MD307-A2</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('sortByDistrict', 'MD307-B1') }}">MD307-B1</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('sortByDistrict', 'MD307-B2') }}">MD307-B2</a>
            </div>
          </div>
    </div>
</div>


{{-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> --}}
@if ($pendaftaran->count())
<div class="table-responsive mt-2">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No.</th>
            <th>District</th>
            <th>Full Name</th>
            <th>Club Name</th>
            <th>Title</th>
            <th>Devotional Period</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>   
        @foreach ($pendaftaran as $pendaftar) 
        <tr align="center">
            <td>{{ $loop->iteration + $pendaftaran->firstItem() - 1 }}</td>
            <td>{{ $pendaftar->district ?? "-" }}</td>
            <td>{{ $pendaftar->full_name }}</td>
            <td>{{ $pendaftar->club_name == "" || $pendaftar->club_name == null ? '-' : $pendaftar->club_name }}</td>
            <td>{{ $pendaftar->title ?? '-'}}</td>            
            <td><b class="badge bg-success text-light fs-6">{{ date('Y', strtotime($pendaftar->member_activate_in)). " - " . date('Y', strtotime($pendaftar->member_over_in))}}</b></td>            
            <td align="center" class="d-block justify-content-center">
                <a href="/details/show/{{ $pendaftar->id }}" class="btn bg-primary btn-sm text-light bold mx-2">Lihat Detail</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

@else

<p class="text-center my-4 fs-4">Anggota Tidak Ditemukan.</p>    
@endif

<div class="d-flex justify-content-center" >
{{ $pendaftaran->links() }}
</div>

@endsection