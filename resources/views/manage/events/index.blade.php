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

<h1 class="h3 mb-2 text-gray-800">Manage Events</h1>

{{-- <form action="/manage/unpaid" method="get" class="d-sm-inline-block form-inline mr-auto ml-md-12 my-2 my-md-0 w-100">
    <div class="input-group">
        <input type="text" class="form-control bg-light border-1 small" placeholder="Cari Peserta..."
        name="search" aria-label="Search" aria-describedby="basic-addon2" value="{{ request('search') }}">
        <div class="input-group-append">
        <button class="btn btn-primary" style="z-index: 0" type="submit">
            <i class="fas fa-search fa-sm"></i>
        </button>
        </div>
    </div>
</form> --}}


{{-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> --}}
    <a href="/manage/events/create" class="btn btn-primary mb-3">Tambahkan Event Baru</a>
@if ($events->count())
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No.</th>
            <th>Event Name</th>
            <th>Registration Start At</th>
            <th>Registration End At</th>
            <th>Event Start At</th>
            <th>Event End At</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>   
        @foreach ($events as $event) 
        <tr align="center">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $event->event_name }}</td>
            <td>{{ \Carbon\Carbon::parse($event->registration_start_at)->format('d-m-Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($event->registration_end_at)->format('d-m-Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($event->event_start_at)->format('d-m-Y') }}</td>    
            <td>{{ \Carbon\Carbon::parse($event->event_end_at)->format('d-m-Y') }}</td>    
            <td align="center" class="d-block justify-content-center">
                <div class="d-flex justify-content-left mb-2">
                    <a href="/manage/events/edit/{{ $event->id }}" class="btn btn-warning mx-1"><b>Edit</b></a>
                    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#delete{{ $event->id }}"><b>Delete</b></button>
                </div>
            </td>
        </tr>
        <div class="modal hide fade in" tabindex="-1" id="delete{{ $event->id }}" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark bold">Hapus Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin Menghapus Event ini?
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" align="right" data-dismiss="modal">Batal</button>
                
                <!-- DELETE METHOD ON MODAL -->
                <form method="POST" action="/manage/events/destroy/{{ $event->id }}">
                @csrf
                @method('delete')
                <button type="submit" class="btn bg-danger btn-sm bold mt-2" style="color: black">Konfirmasi Penghapusan</button>
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

<p class="text-center my-4 fs-4">Event Tidak Ditemukan.</p>    
@endif

@endsection