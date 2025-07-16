<section style="background-color: #eee;">
    <div class="container py-5">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="d-flex card rounded-3 p-3 mb-4 align-items-center" style="color: black;">
            <h5 class="bold">Data Diri Peserta</h5>
            </nav>
        </div>
    </div>

    <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card mb-4">
            <div class="card-body text-center">
    
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp" alt="avatar"
                class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="mt-3 bold" style="color: dimgray">{{ $member->full_name }}</h5>     
            <p class="text-muted mb-2 fs-6">Title : {{ $member->title ?? "-" }}</p>        
            @if($member->status == 'PENDING')
            <p class="badge bg-danger fs-6">Inactive</p>
            @endif
            @if ($member->member_over_in)
            <p class="badge bg-success fs-6 mb-1"><b>Devotional Period: {{ date('Y', strtotime($member->member_activate_in)). " - " . date('Y', strtotime($member->member_over_in))}}</b></p> 
            @endif
            </div>
        </div>
        @if ($member->status == 'SUCCESS' && $uuid)
            <div class="my-4">
                @include('dashboard.name-tag-pdf')
            </div>
        @endif
        </div>
        
        <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Email Address</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $member->email }}</p>
                    {{-- @if ($member->user->email_verified_at == null)
                    <p class="text-muted mb-0">{{ $member->user->email }} <span data-feather="alert-octagon" stroke="red" class="d-inline mx-3" alt="Alamat Email Belum di-verifikasi"></span></p>
                    @else
                    <p class="text-muted mb-0">{{ $member->user->email }} <span data-feather="user-check" stroke="green" class="d-inline mx-3" alt="Alamat Email Berhasil di-verifikasi"></span></p>
                    @endif --}}
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Country</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $member->country ? strtoupper($member->country) : '-' }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">City</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $member->city }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Province</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $member->province }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">ZIP Code</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $member->zip }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Phone Number</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $member->phone_number }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Alternate Phone Number</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $member->alternate_phone_number }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Club Name</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $member->club_name ?? '-' }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">District</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $member->district }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Address 1</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $member->address_1 }}</p>
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-sm-4">
                    <p class="mb-0">Address 2</p>
                </div>
                <div class="col-sm-8">
                    <p class="text-muted mb-0">{{ $member->address_2 ?? '-' }}</p>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="modal hide fade in" tabindex="-1" id="cancel{{ $member->id }}" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark bold">Registration Cancellation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="post" action="/details/destroy/{{ $member->id }}">
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
    </div>
</section>