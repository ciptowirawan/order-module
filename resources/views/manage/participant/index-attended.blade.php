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

<h1 class="h3 mb-2 text-gray-800">Presence <span class="badge badge-success">Hadir</span></h1>

<form action="/dashboard/presence-attended" method="get" class="d-sm-inline-block form-inline mr-auto ml-md-12 my-2 my-md-0 w-100">
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
    <div class="dropdown">
        <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
            <b>Export as Pdf By District</b>&nbsp;<i class="fa-solid fa-file-pdf"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-start">
            <a class="dropdown-item" href="{{ route('export-attended-pdf-by-district', 'MD307-A1') }}">MD307-A1</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('export-attended-pdf-by-district', 'MD307-A2') }}">MD307-A2</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('export-attended-pdf-by-district', 'MD307-B1') }}">MD307-B1</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('export-attended-pdf-by-district', 'MD307-B2') }}">MD307-B2</a>
        </div>
    </div>
    </div>

    <div class="d-flex justify-content-end mr-1">
        @if (request()->route('district'))
            <a href="/dashboard/presence-attended" class="btn btn-danger mr-2">
                Cancel Sorting
            </a>
        @endif
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                Sort By District
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('sort-attended-by-district', 'MD307-A1') }}">MD307-A1</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('sort-attended-by-district', 'MD307-A2') }}">MD307-A2</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('sort-attended-by-district', 'MD307-B1') }}">MD307-B1</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('sort-attended-by-district', 'MD307-B2') }}">MD307-B2</a>
            </div>
          </div>
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
            <th>Check In</th>
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
            <td>{{ $pendaftar->updated_at ?? '-' }}</td>
            {{-- <td align="center" class="d-flex justify-content-around" style="gap: 10px">
                <button type="button" class="btn btn-info bold font-weight-bold" data-toggle="modal" data-target="#presence{{ $pendaftar->id }}">Confirm Presence</button>
            </td> --}}
        </tr>

        <div class="modal hide fade in" tabindex="-1" id="presence{{ $pendaftar->id }}" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark bold">Konfirmasi Kehadiran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form method="post" action="/dashboard/presence/update/{{ $pendaftar->id }}">
                    @csrf
                    @method('PUT')
                    <b>Apakah anda yakin ingin mengkonfirmasi kehadiran peserta ini?</b>
                    <div class="p-2" style="color: black;">
                        <label for="uuid" class="mr-2">UUID Anggota:</label>
                        <input type="text" name="uuid" class="form-control @error('uuid') is-invalid @enderror" value="{{ old('uuid') }}" autocomplete="uuid" autofocus required>
                    </div>
                    @error('uuid')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" align="right" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info bold" style="color: black">Konfirmasi Kehadiran</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
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