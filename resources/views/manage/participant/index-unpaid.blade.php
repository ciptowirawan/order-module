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

<h1 class="h3 mb-2 text-gray-800">Daftar Anggota <span class="badge badge-danger">Inactive</span></h1>

<form action="/manage/unpaid" method="get" class="d-sm-inline-block form-inline mr-auto ml-md-12 my-2 my-md-0 w-100">
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

<div class="row my-3">
    <div class="col-md-12">
        <a href="{{ route('export-unpaid-pdf') }}" class="btn btn-danger w-100"><b>Export as Pdf</b>&nbsp;<i class="fa-solid fa-file-pdf"></i></a>
    </div>        
</div>

{{-- <div class="d-flex justify-content-end my-3">
<a href="{{ route('export-users') }}" class="btn btn-primary" style="background-color: darkgreen">Lihat peserta yang sudah membayar dalam Excel <i class="fa-regular fa-file-excel fa-xl"></i></a>
</div> --}}

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
            <th>Amount</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>   
        @foreach ($pendaftaran as $pendaftar) 
        <tr align="center">
            <td>{{ $loop->iteration + $pendaftaran->firstItem() - 1 }}</td>
            <td>{{ $pendaftar->district ?? '-'}}</td>
            <td>{{ $pendaftar->full_name }}</td>
            <td>{{ $pendaftar->club_name == "" || $pendaftar->club_name == null ? '-' : $pendaftar->club_name }}</td>
            <td>{{ $pendaftar->title ?? '-' }}</td>
            <td>{{ number_format($pendaftar->amount, 2) ?? '-' }}</td>
            <td align="center" class="d-flex justify-content-around" style="gap: 10px">
                <a href="/details/show/{{ $pendaftar->id }}" class="font-weight-bold btn btn-primary btn-sm" > Lihat Detail</a>
            </td>
        </tr>

        @endforeach
        </tbody>
    </table>
</div>

@else

<p class="text-center my-4 fs-4">Peserta Tidak Ditemukan.</p>    
@endif

<div class="d-flex justify-content-center" >
{{ $pendaftaran->links() }}
</div>

@push('body-scripts')
    @once
        <script src="{{ asset('js/participant.js') }}"></script>
    @endonce
@endpush

@endsection
