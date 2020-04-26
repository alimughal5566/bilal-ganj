@extends('layout.frontend-layout')

@section('title','Advertisement Form')

@section('content')
    <h3>Add Product to ebay by clicking here</h3>
    <form method="get" action="{{route("product.details",5)}}">
        @csrf
        <input type="hidden" value="5">
        <button class="btn-primary">Click</button>
    </form>
    @endsection