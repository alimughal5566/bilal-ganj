@extends('layout.rider-layout')
@section('title','Rider Panel')
@section('content','Account Details')
@section('rightPane')
    @php
        $rider = $user->rider->first();
    @endphp
    <div class="col-sm-12 offset-md-1 offset-lg-2 col-md-6 col-lg-5">
        <div class="tab-content dashboard_content">
            @if($message = Session::get('success'))
                <div class="alert alert-success">
                    {{$message}}
                </div>
            @endif
            <table class="table table-striped text-center">
                <thead>
                <tr>
                    <th colspan="2">Account Info</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>User Name</th>
                    <td>{{$user->name}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{$user->email}}</td>
                </tr>
                <tr>
                    <th>Salary</th>
                    <td>{{$rider->salary}} PKR</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{$user->address}}</td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td>{{$user->contact_number}}</td>
                </tr>
                <tr>
                    <th>Vechile Number</th>
                    <td>{{$rider->vehicle_number}}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a href="{{route('riderEditProfile',[$user])}}">
                            <button class="btn btn-primary">Edit Profile</button>
                        </a>
                        <a href="{{route('riderChangePassword')}}">
                            <button class="btn btn-primary">Change Password</button>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
