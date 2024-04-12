<!-- <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body text-center">
    
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp" alt="avatar"
                class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3 bold" style="color: dimgray">{{ $previousData['first_name']. " " .$previousData['last_name'] }}</h5>     
            <p class="text-muted mb-1">Title : <b>{{ $previousData['title'] . ' - '. $previousData['registration_type'] }}</b></p>        
            <p class="badge bg-{{$pendaftaran->payment->status == 'paid' ? 'success' : 'danger'}} fs-6">{{ $pendaftaran->payment->status }}
            </div>
        </div>
        </div> -->
        
        
    <div class="card mb-4">
    <div class="card-body">
        <div class="row {{ $previousData['email'] == $pendaftaran->email ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">Email Address</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0 ">{{ $previousData['email'] }} <span data-feather="alert-octagon" stroke="red" class="d-inline mx-3" alt="Alamat Email Belum di-verifikasi"></span></p>
        </div>
        </div>
        <hr>
        <div class="row {{ $previousData['country'] == $pendaftaran->country ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">Country</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0 ">{{ $previousData['country'] ?? '-' }}</p>
        </div>
        </div>
        <hr>
        <div class="row {{ $previousData['city'] == $pendaftaran->city ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">City</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0">{{ $previousData['city'] }}</p>
        </div>
        </div>
        <hr>
        <div class="row {{ $previousData['province'] == $pendaftaran->province ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">Province</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0 ">{{ $previousData['province'] }}</p>
        </div>
        </div>
        <hr>
        <div class="row {{ $previousData['zip'] == $pendaftaran->zip ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">ZIP Code</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0">{{ $previousData['zip'] }}</p>
        </div>
        </div>
        <hr>
        <div class="row {{ $previousData['phone_number'] == $pendaftaran->phone_number ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">Phone Number</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0 ">{{ $previousData['phone_number'] }}</p>
        </div>
        </div>
        <hr>
        <div class="row {{ $previousData['alternate_phone_number'] == $pendaftaran->alternate_phone_number ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">Alternate Phone Number</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0">{{ $previousData['alternate_phone_number'] }}</p>
        </div>
        </div>
        <hr>
        <div class="row {{ $previousData['club_number'] == $pendaftaran->club_number ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">Club Number</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0">{{ $previousData['club_number'] }}</p>
        </div>
        </div>
        <hr>
        <div class="row {{ $previousData['club_name'] == $pendaftaran->club_name ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">Club Name</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0 ">{{ $previousData['club_name'] }}</p>
        </div>
        </div>
        <hr>
        <div class="row {{ $previousData['emergency_contact'] == $pendaftaran->emergency_contact ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">Emergency Contact</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0">{{ $previousData['emergency_contact'] }}</p>
        </div>
        </div>
        <hr>
        <div class="row {{ $previousData['emergency_phone_number'] == $pendaftaran->emergency_phone_number ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">Emergency Phone Number</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0">{{ $previousData['emergency_phone_number'] }}</p>
        </div>
        </div>
        <hr>
        <div class="row {{ $previousData['district'] == $pendaftaran->district ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">District</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0">{{ $previousData['district'] }}</p>
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
        <div class="row {{ $previousData['address_1'] == $pendaftaran->address_1 ? '' : 'bg-warning' }}" >
        <div class="col-sm-4">
            <p class="mb-0">Address 1</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0">{{ $previousData['address_1'] }}</p>
        </div>
        </div>
        <hr>
        <div class="row {{ $previousData['address_2'] == $pendaftaran->address_2 ? '' : 'bg-warning' }}">
        <div class="col-sm-4">
            <p class="mb-0">Address 2</p>
        </div>
        <div class="col-sm-8">
            <p class="text-muted mb-0">{{ $previousData['address_2'] ?? '-' }}</p>
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