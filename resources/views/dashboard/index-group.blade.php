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
    @if ($amount)
    <div class="card shadow mb-5 col-md-12 col-xs-12" align="center">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Membership Payment Details</h6>
        </div>
        <div class="card-body py-3">
            <h5 class="mb-2 font-weight-bold text-dark">Lions Clubs Multiple District 307</h5>
            <h5 class="mb-4 text-dark">Biaya Pendaftaran: <b>IDR {{ number_format($amount,0) }}</b></h5>
            <div class="p-3 border" style="width: 300px; background:#c5c7c5ec">
                <strong id='virtualAccount'>{{$member->virtual_account}}</strong><br>
                <button onclick='copyVirtualAccount()' class='btn btn-primary mt-2'><b>Copy Virtual Account</b></button>
            </div>
        </div>
    </div>    
    @endif

    <p class="text-gray" style="font-weight: 600;">Terima kasih telah melakukan registrasi pada Konvensi Lions MD 307 Ke - 49. Berikut adalah rincian pendaftaran anda:</p>

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

<div class="d-flex justify-content-center">

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

    // function copyVirtualAccount() {
    //     var virtualAccount = document.getElementById('virtualAccount');
    //     navigator.clipboard.writeText(virtualAccount.textContent)
    //         .then(() => alert('Virtual Account copied to clipboard!'));
    // }

    function copyVirtualAccount() {
        var virtualAccountElement = document.getElementById('virtualAccount');
        var textToCopy = virtualAccountElement.textContent;

        // Create a temporary textarea element
        var textArea = document.createElement("textarea");
        textArea.value = textToCopy;

        // Make it non-editable and invisible (prevents it from affecting layout)
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px"; // Off-screen
        textArea.style.top = "-999999px";  // Off-screen
        document.body.appendChild(textArea);

        // Select the text within the textarea
        textArea.focus();
        textArea.select();

        try {
            // Execute the copy command
            var successful = document.execCommand('copy');
            if (successful) {
                alert('Virtual Account copied to clipboard!');
            } else {
                alert('Failed to copy virtual account. Please try again or copy manually.');
                console.warn('Failed to copy using document.execCommand.');
            }
        } catch (err) {
            console.error('An error occurred while trying to copy:', err);
            alert('An error occurred while copying: ' + err.message);
        } finally {
            // Remove the temporary textarea from the DOM
            document.body.removeChild(textArea);
        }
    }
</script>