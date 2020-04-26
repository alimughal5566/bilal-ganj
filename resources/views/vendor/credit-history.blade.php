@extends('layout.vendor-layout')

@section('title','Vendor Panel')

@section('rightPane')
    <div class="col-sm-12 col-md-9 col-lg-9">
        <center>
            <h1>Credit Points History</h1>
        </center>
        <form class="shadow p-3">
            <a href="{{route('buyCreditsView',['id'=> Auth::user()->id])}}" class="ml-5 d-flex justify-content-end">
                <h3 class="ml-5">
                    <i class="fas fa-cash-register"> </i>
                </h3>
                Buy Credit Points Now
            </a>
            <div class="ml-5">
                <h3>Transaction History</h3>
            </div>

            @foreach($credit as $credits)
                <div class="row shadow m-5">
                    <div class=" p-5">
                        <h1><i class="fas fa-spinner fa-pulse"></i></h1>
                        <small>{{$credits['created_at']}}</small>
                        <h4>Transected amount  {{$credits['amount']}}</h4>
                        <h4>Total credit Points  {{$credits['credits']}}</h4>
                    </div>
                </div>
                @endforeach
        </form>
    </div>
@endsection