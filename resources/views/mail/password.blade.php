@extends('layout.mail-layout')
@section('title','Password')
@section('body')
    <h3>Your Credential are Given below:</h3>
    <ul>
        <li>Email : {{$email}}</li>
        <li>Password : {{$password}}</li>
    </ul>
@endsection
