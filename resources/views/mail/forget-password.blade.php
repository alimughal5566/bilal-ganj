@extends('layout.mail-layout')
@section('title','Forget Password')
@section('body')

    To reset your password click on given link {{$name}}
    <a href="{{route('forgetPasswordDoneView',["email"=> $email])}}"> Click here</a>

@endsection
