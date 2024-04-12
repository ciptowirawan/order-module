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

<h1 class="h3 mb-2 text-gray-800">Pendaftaran</h1>

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

{{-- <div class="d-flex justify-content-end my-3">
<a href="{{ route('export-users') }}" class="btn btn-primary" style="background-color: darkgreen">Lihat peserta yang sudah membayar dalam Excel <i class="fa-regular fa-file-excel fa-xl"></i></a>
</div> --}}

{{-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> --}}
@if ($pendaftaran->count())
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No.</th>
            <th>Full Name</th>
            <th>Registration Type</th>
            <th>Title</th>
            <th>Amount</th>
            <th>Payment Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>   
        @foreach ($pendaftaran as $pendaftar) 
        <tr align="center">
            <td>{{ $loop->iteration + $pendaftaran->firstItem() - 1 }}</td>
            <td>{{ $pendaftar->full_name }}</td>
            <td>{{ $pendaftar->registration_type ?? '-'}}</td>
            <td>{{ $pendaftar->title ?? '-' }}</td>
            <td>{{ number_format($pendaftar->amount, 2) ?? '-' }}</td>
            <td>
                <span class="badge badge-{{$pendaftar->status == 'paid' ? 'success' : 'danger'}}">{{ $pendaftar->status ?? '-' }}</span>
            </td>
            <td align="center" class="d-block justify-content-center">
                <a href="/dashboard/detail/{{ $pendaftar->user->id }}" class="font-weight-bold btn bg-primary btn-sm text-light mx-2" > Lihat Detail <span data-feather="eye"></span></a>
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

@endsection