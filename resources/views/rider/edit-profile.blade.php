@extends('layout.rider-layout')
@section('title','Rider Panel')
@section('content','Account Details')
@section('rightPane')
    @php
        $rider = $user->rider->first();
    @endphp
    <div class="col-sm-12 offset-md-1 offset-lg-2 col-md-6 col-lg-5">
        <div class="tab-content dashboard_content">
            <form method="post" action="{{route('riderEditedProfile')}}" class="needs-validation p-3 account_form" novalidate>
                @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <div class="form-group">
                    <div>Contact Number:</div>
                    <input type="number" class="form-control" name="contact_number" value="{{$user->contact_number}}" required>
                    @include('error.error', ['filed' => 'contact_number'])
                    <div class="invalid-feedback">
                        Valid Contact Number Required
                    </div>
                </div>
                <div class="form-group">
                    <div>Address:</div>
                    <textarea rows="3" cols="68" class="form-control size" name="address" required>{{$user->address}}</textarea>
                    @include('error.error', ['filed' => 'address'])
                    <div class="invalid-feedback">
                        Address is Required
                    </div>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary">Save Change</button>
                </div>
            </form>
        </div>
    </div>
@endsection
