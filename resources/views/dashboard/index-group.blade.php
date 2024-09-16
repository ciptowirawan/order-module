@extends('layouts.header')
@section('content')
{{-- @if($members[0]->group_id == null)

    <div class="modal hide fade in" tabindex="-1" id="newFeature" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title bold" style="color: black">Sekarang, Kamu bisa Mendaftarkan Anggota Grup Kamu!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
            </div>
            <div class="modal-body" class="text-justify text-dark">
                <p>Kamu sekarang dapat mendaftarkan peserta baru sebagai bagian dari Grup anda. <br> Jadi tunggu apa lagi, Segera Daftarkan Anggota Grup Kamu dan berlarilah bersama-sama! </p>
                </div>
                <div class="modal-footer">
                    <a href="/register/create-group" style="background-color: #009c08ec" type="button" class="btn text-light bold">Daftarkan anggota Grup Sekarang!</a>
                    <button type="button" class="btn btn-secondary bold" data-bs-dismiss="modal">Nanti Saja</button>
                </div>
            </div>
        </div>
    </div>
@endif --}}

<!-- Page Heading -->
<div class="m-5">
    <h1 class="h3 mb-2 text-dark bold">My Dashboard</h1>
    {{-- <button class="btn btn-outline-secondary bg-light btn-block w-100 p-3 mb-3 my-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample{{$member->id}}" aria-bs-expanded="false" aria-bs-controls="collapseExample">  
        <div class="row align-items-center">
            <div class="col-lg-9 col-sm-10 text-start bold text-dark">
                {{$member->full_name}}
            </div>
            <div class="col-lg-3 col-sm-2 d-flex justify-content-end">
                @if ($member->status == "PENDING")
                <div class="btn btn-unpaid w-70 text-light">
                    <b>Unpaid</b>&ensp;<i class="fa-solid fa-circle-exclamation fa-xl"></i> 
                </div>
                @endif
                @if ($member->status == "SUCCESS")
                    <div class="btn btn-paid w-70 text-light">
                        <b>Paid</b>&ensp;<i class="fa-solid fa-circle-check fa-xl"></i> 
                    </div>
                @endif
            </div>
        </div>
    </button> --}}
    @if ($amount)
    <div class="card shadow mb-2 col-md-12 col-xs-12" align="center">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Membership Payment Details</h6>
        </div>
        <div class="card-body py-3">
            <h5 class="mb-2 font-weight-bold text-dark">Lions MD-307 Indonesia</h5>
            <h5 class="mb-4 text-dark">Biaya Pendaftaran: <b>IDR {{ number_format($amount,0) }}</b></h5>
        </div>
    </div>    
    @endif

    <p class="my-4 text-gray" style="font-weight: 600;">Terima kasih telah melakukan registrasi pada Konvensi Lions MD 307 Ke - 49. Berikut adalah rincian pendaftaran anda:</p>

    @error('payment_evidence')
    <div class="row alert alert-danger col-12 mt-2" role="alert">
       {{ $message }}
    </div>
    @enderror
    @if (session()->has('success'))
    <div class="row alert alert-success col-12 mt-2" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if (session()->has('error'))
        <div class="row alert alert-danger col-12 mt-2" role="alert">
        {{ session('error') }}
        </div>
    @endif
</div>
 
@include('dashboard.detail')

{{-- <div class="d-flex justify-content-center my-4">
    <a class="btn btn-outline-purple bold" href="/register/create-group">Daftarkan Anggota <i class="fa-solid fa-person-circle-plus fa-lg"></i></a>
</div> --}}
{{-- 
<hr class="mx-3">

<div class="card bg-secondary p-3 mx-5 my-4">
    <p class="bold text-light">Registration Fee Payment Details :</p>

    @foreach ($members as $member)  
    
        <button class="btn btn-outline-secondary bg-light btn-block w-100 p-3 mb-3 my-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample{{$member->id}}" aria-bs-expanded="false" aria-bs-controls="collapseExample">  
            <div class="row align-items-center">
                <div class="col-lg-9 col-sm-10 text-start bold text-dark">
                    {{$member->full_name}}
                </div>
                <div class="col-lg-3 col-sm-2 d-flex justify-content-end">
                    @if ($member->payment->payment_evidence == null)
                    <div class="btn btn-unpaid w-70 text-light">
                        <b>Unpaid</b>&ensp;<i class="fa-solid fa-circle-exclamation fa-xl"></i> 
                    </div>
                    @endif
                    @if ($member->payment->payment_evidence !== null && $member->payment->status == "unpaid" )
                        <div class="btn btn-pending w-70 text-light">
                            <b>On Process</b>&ensp;<i class="fa-solid fa-hourglass-start fa-xl"></i> 
                        </div>
                    @endif
                    @if ($member->payment->status == "paid")
                        <div class="btn btn-paid w-70 text-light">
                            <b>Paid</b>&ensp;<i class="fa-solid fa-circle-check fa-xl"></i> 
                        </div>
                    @endif
                </div>
            </div>
        </button>
        <div class="collapse {{$members->count() == 1 ? 'show' : null }}" id="collapseExample{{$member->id}}" style="width: 100%;" >
            @if ($member->payment->payment_evidence == null)
            <div class="card shadow mb-2 col-md-12 col-xs-12" align="center">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Convention Payment Details</h6>
                </div>
                <div class="card-body py-3">
                    <h5 class="mb-2 font-weight-bold text-dark">Lions MD-307 Indonesia</h5>
                    <h5 class="mb-4 text-dark">Biaya Pendaftaran: <b>IDR {{ number_format($member->payment->amount,0) }}</b></h5>
                </div>
                <div class="card-footer">
                    <div class="text-muted" align="center">
                        <ul>
                            <li>Hanya menerima file bertipe JPEG, JPG, PNG, BMP, TIFF.</li>
                            <li>maksimal file berukuran 6MB</li>
                        </ul>
                        <button type="button" class="btn btn-primary font-weight-bold" data-bs-toggle="modal" data-bs-target="#upload{{$member->id}}">Upload Payment Evidence</button>
                    </div>
                </div>
            </div>
            @else
                <div class="col-md-12 col-xs-12 mb-2">
                    <!-- DataTales Example -->
                    <div class="card shadow" align="center">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Convention Payment Details</h6>
                        </div>
                        <div class="card-body">
                            @if ($member->payment->status == 'paid')
                            Congratuliations! Your payment has been approved by Lions MD-307 Indonesia.
                            @else
                            Thank you for participating in our event. Your payment is currently being verified by the Lions MD-307 Indonesia Team. We will inform you once the verification is complete. Thank you for your patience!
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div> --}}
{{-- <div class="px-5 my-3">
    <div class="card text-dark bg-light w-100">    
    <div class="card-body">
        <h5 class="card-title">Important Notice!</h5>
        <p class="card-text">refund bisa dilakukan selambat-lambatnya 14 hari setelah konvensi berakhir.</p>
    </div>
    </div>
</div> --}}

<div class="d-flex justify-content-center">
    {{-- <a class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">
        Logout
    </a> --}}

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <!-- <a class="" href="login.html">Logout</a> -->
                    <a class="btn btn-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- <div class="card" style="width: 100%;">
        @if ($loop->iteration == 1)    
            <div class="card-header">
                <div class="d-flex justify-content-between px-4">
                    <div>
                        {{$member->full_name}}
                    </div>
                    <div class="bold">
                        IDR {{ number_format($member->payment->amount,0) }}
                    </div>
                </div>
            </div>
            @else
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <div class="d-flex justify-content-between px-4">
                    <div>
                        {{$member->full_name}}
                    </div>
                    <div>
                        IDR {{ number_format($member->payment->amount,0) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        {{$member->full_name}}
                    </div>
                    <div class="col-md-4">
                        IDR {{ number_format($member->payment->amount,0) }}
                    </div>
                </div>
              </li>
            </ul>

        @endif
        @endforeach
        <div class="card-footer mt-5">
            <div class="row justify-content-end bold">
                <div class="col-md-10 d-flex justify-content-end">
                    Total :
                </div>
                <div class="col-md-2">
                    IDR {{ number_format($amount,0) }}
                </div>
            </div>
          </div>
      </div>
      <div class="row">
        <div class="col-md-6 d-flex justify-content-end">
            <a href="/details/show/{{ auth()->user()->id }}" class="btn btn-secondary"><span data-feather="credit-card"></span> Manage</a>
        </div>
        <div class="col-md-6 d-flex justify-content-start">
            <a href="" class="btn btn-primary"><span data-feather="credit-card"></span> Payment</a>
        </div>
      </div> --}}

@push('additional-styles')
    @once
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    @endonce
@endpush

@push('body-scripts')
    @once
        <script src="{{ asset('js/dashboard.js') }}"></script>
    @endonce
@endpush
@endsection 


<script>
    function previewImage(memberId) {
    //   const image = document.querySelector('#bukti_pembayaran');
    //   const imgPreview = document.querySelector('.img-preview'); // this access elements that have a Class name
    const image = document.querySelector(`#payment_evidence_${memberId}`);
    const imgPreview = document.querySelector(`#img_preview_${memberId}`);

    imgPreview.style.display = 'block';

    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
    }
    }
</script>