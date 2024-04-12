@extends('layouts.header')
@section('content')
    
<section style="background-color: #eee;">
    <div class="container py-5">
        @if (session()->has('success'))
        <div class="row alert alert-success ml-2 text-center col-12" role="alert">
            {{ session('success') }}
        </div>
        @endif
        @if (session()->has('error'))
            <div class="row alert alert-danger text-center ml-2 col-12" role="alert">
            {{ session('error') }}
            </div>
        @endif
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="d-flex card rounded-3 p-3 mb-4 align-items-center" style="color: black;">
            <h5 class="bold">Data Diri Peserta</h5>
            </nav>
        </div>
        </div>

    <div class="row">
        <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body text-center">
    
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp" alt="avatar"
                class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3 bold" style="color: dimgray">{{ $pendaftaran->first_name. " " .$pendaftaran->last_name }}</h5>     
            <p class="text-muted mb-1"><b>{{ $pendaftaran->title ? $pendaftaran->title . ' - '. $pendaftaran->registration_type : $pendaftaran->registration_type }}</b></p>        
            <p class="badge bg-{{$pendaftaran->payment->status == 'paid' ? 'success' : 'danger'}} fs-6">{{ $pendaftaran->payment->status }}
            </div>
        </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Email Address</p>
                </div>
                <div class="col-sm-8">
                    @if ($pendaftaran->user->email_verified_at == null)
                    <p class="text-muted mb-0">{{ $pendaftaran->user->email }} <span data-feather="alert-octagon" stroke="red" class="d-inline mx-3" alt="Alamat Email Belum di-verifikasi"></span></p>
                    @else
                    <p class="text-muted mb-0">{{ $pendaftaran->user->email }} <span data-feather="user-check" stroke="green" class="d-inline mx-3" alt="Alamat Email Berhasil di-verifikasi"></span></p>
                    @endif
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Country</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->country ?? '-' }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">City</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->city }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Province</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->province }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">ZIP Code</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->zip }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Phone Number</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->phone_number }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Alternate Phone Number</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->alternate_phone_number }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Club Number</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->club_number }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Club Name</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->club_name }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Emergency Contact</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->emergency_contact }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Emergency Phone Number</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->emergency_phone_number }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">District</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->district }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Status Pembayaran</p>
                </div>
                <div class="col-sm-8">
                    <p class="fs-6 badge bg-{{$pendaftaran->payment->status == 'paid' ? 'success' : 'danger'}}">{{ $pendaftaran->payment->status }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Email</p>
                </div>
                <div class="col-sm-8">
                    @if ($pendaftaran->user->email_verified_at == null)
                    <p class="text-muted mb-0">{{ $pendaftaran->user->email }} <span data-feather="alert-octagon" stroke="red" class="d-inline mx-3" alt="Alamat Email Belum di-verifikasi"></span></p>
                    @else
                    <p class="text-muted mb-0">{{ $pendaftaran->user->email }} <span data-feather="user-check" stroke="green" class="d-inline mx-3" alt="Alamat Email Berhasil di-verifikasi"></span></p>
                    @endif
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Address 1</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->address_1 }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Address 2</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $pendaftaran->address_2 ?? '-' }}</p>
                </div>
                </div>
                <hr>
                
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Amount</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ number_format($pendaftaran->payment->amount,0) }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Payment Date</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{$pendaftaran->payment->payment_date ?? '-'}}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Paid Amount</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{$pendaftaran->payment->paid_amount == null ? '-' : number_format($pendaftaran->payment->paid_amount,0)}}</p>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="my-2 btn-block" align="center">
        @if($history > 0)
        <a href="/details/modify/{{$pendaftaran->id}}" class="btn btn-secondary bold">See History</a>
        @endif
        <a href="/details/edit/{{$pendaftaran->id}}" class="btn mx-2 btn-primary bold">Modify</a>
        <button type="button" class="btn btn-danger bold" data-bs-toggle="modal" data-bs-target="#cancel{{ $pendaftaran->user->id }}">Cancel Registration</button> 
    </div>

    <div class="modal hide fade in" tabindex="-1" id="cancel{{ $pendaftaran->user->id }}" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark bold">Registration Cancellation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="post" action="/details/destroy/{{ $pendaftaran->user->id }}">
                @csrf
                @method('delete')
                Are you sure to cancel your registration? (all your data would be loss)
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" align="right" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger bold mt-2">Confirm Cancellation</button>
            </form>
        </div>
        </div>
    </div>
    </div>
        
    <a href="/" class="btn btn-primary"><span data-feather="corner-down-left"></span> Back to Home Page</a>
    </div>
</section>
    
@endsection
