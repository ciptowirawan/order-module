@extends('layouts.header')
@section('content')

<div class="title">
    <div class="title-text">
        <h1>Ticketed Events</h1>
        <p>At LionsCon, we offer several special events that you don’t want to miss, so be sure to purchase your tickets! </p>
    </div>
</div>

<div class="hr-info my-5 mx-4">
    <h1>Enhance your LionsCon experience</h1>
    <hr class="small-hr">

    <p>Make plans to attend these special events that celebrate our service, our generosity and our Lion leaders. Purchase your tickets when you register for convention or add them to your existing registration later.</p>
</div>

<div class="fellowship">
    <div class="row d-flex justify-content-between">
        <div class="col-md-6">
            <img src="https://images.unsplash.com/photo-1572319663329-ac47c4efdef0?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid" style="width: 90%" alt="">
        </div>
        <div class="col-md-6">
            <h2 class="bold">Past International President, Past <br> International Director, District <br> Governor, Past District Governor <br> Banquet</h2>
            <p>Exclusively for past international presidents (PIPs), past international directors (PIDs), district governors (DGs), past district governors (PDGs) and their guests, this formal event honors our Lion leaders and offers the opportunity to connect with peers while enjoying a delicious meal.</p>
        </div>
    </div>
</div>

<div class="ticket-suggestions">
    <div class="row">
        <div class="col-md-10">
            <h2 class="bold">Get your tickets today!</h2>
            <p>Purchase your tickets to these special events.</p>
        </div>
        <div class="col-md-2">
            <a href="/register" class="btn bold">Order now</a>
        </div>
    </div>
</div>

<div class="badge-suggestions">
    <div class="row">        
        <h2 class="bold">Bring your badge</h2>
        <p>Badges will be scanned at the door for admittance to all events.</p>
    </div>
</div>

@endsection