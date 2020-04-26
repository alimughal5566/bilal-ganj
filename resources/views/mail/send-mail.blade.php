@extends('layout.mail-layout')
@section('title','Send Email')
@section('body')
    Hi {{$name}}<br><br>
    <p>You have receive an activation email from Bilal Ganj. Please click on following link to verify account.</p>
    <a href="{{route('sendEmailDone',["email"=> $email])}}">Verify Email</a><br>
    <p>
        Best Regards<br>
        <a href="#">Team Bilal Ganj</a>
    </p>
@endsection
