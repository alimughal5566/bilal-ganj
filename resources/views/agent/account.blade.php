@extends('layout.agent-layout')

@section('title','Account Details')

@section('content','Account Details')

@section('rightPane')
    <div class="col-md-5 col-lg-4">
        <div class="tab-content dashboard_content">
            <div class="tab-pane fade active" id="account-details">
                <h3>Account details </h3>
                <div class="">
                    <div class="login">
                        <div class="login_form_container">
                            <div class="account_login_form account_form">
                                <div class="form-row">
                                    <strong class="col">Name:</strong>
                                    <div class="col">{{Auth::user()->name}}</div>
                                </div>
                                <div class="form-row">
                                    <strong class="col">Email:</strong>
                                    <div class="col">{{Auth::user()->email}}</div>
                                </div>
                                <div class="form-row">
                                    <strong class="col">Qualification:</strong>
                                    <div class="col">{{Auth::user()->agent()->first()->qualification}}</div>
                                </div>
                                <div class="form-row">
                                    <strong class="col">Salary:</strong>
                                    <div class="col">{{Auth::user()->agent()->first()->salary}} PKR</div>
                                </div>
                                <div class="form-row">
                                    <strong class="col">Contact Number:</strong>
                                    <div class="col">{{Auth::user()->contact_number}}</div>
                                </div>
                                <div class="form-row">
                                    <strong class="col">Date of Joining:</strong>
                                    <div class="col">{{Auth::user()->agent()->first()->date_of_joining = date('d-M-Y')}}</div>
                                </div>
                                <div class="form-row">
                                    <strong class="col">Address:</strong>
                                    <div class="col">{{Auth::user()->address}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection