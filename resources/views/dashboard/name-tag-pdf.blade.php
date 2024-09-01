{{-- <div class="name-tag-card">
    <h5>Lions MD 307 Convention Indonesia</h5>
    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp" alt="avatar"
        class="rounded-circle img-fluid" style="width: 150px;">

        <h2 class="name">{{ $member->full_name }}</h2>
        <h2 class="name">{{ $member->full_name }}</h2>
        <p class="title">{{ $member->title }}</p>    
    <img src="{{ asset('storage/qrcodes/' . $uuid. ".png") }}" class="img-fluid" alt="">
</div> --}}

<div class="card" style="width: 18rem;">
    <h5>Lions MD 307 Convention Indonesia</h5>
    <div class="card-body">
    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp" alt="avatar"
    class="rounded-circle img-fluid" style="width: 150px;">
      <h5 class="card-title">{{ $member->full_name }}</h5>
      <p class="card-text">{{ $member->title }}</p>
      <img src="{{ asset('storage/qrcodes/' . $uuid. ".png") }}" class="img-fluid" alt="">
    </div>
  </div>