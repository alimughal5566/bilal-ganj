@extends('layout.vendor-layout')

@section('title','Vendor Panel')
@section('content','Account Details')
@section('rightPane')
    <div class="col-sm-12 col-md-3 col-lg-5">
        <div class="" id="account-details">
            <h3>Change Password </h3>
            <div class="login">
                <div class="login_form_container">
                    <div class="account_login_form account_form">
                        <form action="{{route('editVendorPassword')}}" name="editForm"
                              class="needs-validation" method="post" novalidate>
                            @csrf
                            @if($message = Session::get('success'))
                                <div class="alert alert-success">{{$message}}</div>
                            @endif
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            <div>
                                <label>Old Password*</label>
                                <input type="password" class="form-control mb-1" name="old_password"
                                       required>
                                @include('error.error',['filed'=>'old_password'])
                                @if($message = Session::get('error'))
                                    <div class="text-danger">{{$message}}</div>
                                @endif
                                <div class="invalid-feedback">
                                    Old Password is Required
                                </div>
                            </div>
                            <div>
                                <label>New Password*</label>
                                <input type="password" name="password" class="form-control mb-1"
                                       required>
                                @include('error.error',['filed'=>'password'])
                                <div class="invalid-feedback">
                                    New Password is Required
                                </div>
                            </div>
                            <div class="save_button primary_btn default_button">
                                <button type="submit" class="ml-0 mt-1 w-25"><a>Change</a>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection