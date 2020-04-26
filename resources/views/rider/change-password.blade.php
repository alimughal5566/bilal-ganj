@extends('layout.rider-layout')
@section('title','Rider Panel')
@section('content','Account Details')
@section('rightPane')
    <div class="col-sm-12 offset-md-1 offset-lg-2 col-md-6 col-lg-5">
        <div class="tab-content dashboard_content">
            <form method="post" action="{{route('riderChangedPassword')}}" class="needs-validation p-3 account_form" novalidate>
                @csrf
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <div class="form-group">
                    <div>Enter Old Password:</div>
                    <input type="password" class="form-control rider_pass" name="old_password" required>
                    @include('error.error', ['filed' => 'old_password'])
                    <div class="invalid-feedback">
                        Field is Required
                    </div>
                </div>
                <div class="form-group">
                    <div>Enter New Password:</div>
                    <input type="password" class="form-control rider_new_pass" name="password" required>
                    @include('error.error', ['filed' => 'password'])
                    @if($message = Session::get('error'))
                        <div class="text-danger">{{$message}}</div>
                    @endif
                    <div class="invalid-feedback">
                        Field is Required
                    </div>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary">Save Change</button>
                </div>
            </form>
        </div>
    </div>
@endsection
