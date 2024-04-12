
        
        
    <div class="card mb-4">
    <div class="card-body">
        <div class="row">
        <div class="col-sm-4">
            <p class="mb-0">Email Address</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0">{{ $pendaftaran->user->email }} <span data-feather="user-check" stroke="green" class="d-inline mx-3" alt="Alamat Email Berhasil di-verifikasi"></span></p>
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