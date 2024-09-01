{{-- @if ($members->count() > 1)  
    
<div class="modal hide fade in" tabindex="-1" id="delete{{ $member->id }}" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-dark bold">Delete Member</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Are you sure to delete this member?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" align="right" data-bs-dismiss="modal">Cancel</button>
            
            <!-- DELETE METHOD ON MODAL -->
            <form method="post" action="/register/group/delete/{{ $member->id }}">
            @csrf
            @method('delete')
            <button type="submit" class="btn bg-danger rounded btn-sm bold mt-2">Confirm Delete</button>
            </form>
        </div>
        </div>
    </div>
</div>

<div class="accordion w-100 px-5" id="accordionExample">
    @if ($loop->iteration == 1)
        <p class="bold" style="color: black">Group Leader :</p>
    @endif
        <div class="btn btn-block w-100 p-3 {{ $loop->iteration == 1 ? "btn-success" : "btn-outline-primary"}} mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $member->id }}" aria-expanded="true" aria-controls="collapseOne">
            <div class="row align-items-center">
            <div class="col-6 col-sm-10">
                    <div class="text-start bold">
                        {{ $member->full_name }}
                    </div>
            </div>
                @if ($loop->iteration !== 1)
                <div class="col-6 col-sm-2 text-end">
                    @if ($member->payment->payment_evidence == null)
                    <div class="btn btn-unpaid p-1 text-light">
                        <b>Unpaid</b>&ensp;<i class="fa-solid fa-circle-exclamation fa-sm"></i> 
                    </div>
                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $member->id }}">Delete</button>
                    @endif
                    @if ($member->payment->payment_evidence !== null && $member->payment->status == "unpaid" )
                        <div class="btn btn-pending p-1 text-light">
                            <b>On Process</b>&ensp;<i class="fa-solid fa-hourglass-start fa-sm"></i> 
                        </div>
                    @endif
                    @if ($member->payment->status == "paid")
                        <div class="btn btn-paid p-1 text-light">
                            <b>Paid</b>&ensp;<i class="fa-solid fa-circle-check fa-sm"></i> 
                        </div>
                    @endif
                </div>
                @else
                <div class="col-6 col-sm-2 text-end">
                    @if ($member->payment->payment_evidence == null)
                    <div class="btn btn-unpaid p-1 text-light">
                        <b>Unpaid</b>&ensp;<i class="fa-solid fa-circle-exclamation fa-sm"></i> 
                    </div>
                    @endif
                    @if ($member->payment->payment_evidence !== null && $member->payment->status == "unpaid" )
                        <div class="btn btn-pending p-1 text-light">
                            <b>On Process</b>&ensp;<i class="fa-solid fa-hourglass-start fa-sm"></i> 
                        </div>
                    @endif
                    @if ($member->payment->status == "paid")
                        <div class="btn btn-paid p-1 text-light">
                            <b>Paid</b>&ensp;<i class="fa-solid fa-circle-check fa-sm"></i> 
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    <div id="collapseOne{{ $member->id }}" class="collapse mb-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        @include('dashboard.detail-section')
    </div>
    @if ($loop->iteration == 1)
        <p class="bold" style="color: black">Group Leader: {{$members->count() - 1}} People</p>
    @endif
</div>

@endif --}}

<div class="px-5">
    @include('dashboard.detail-section')
</div>
