@extends('layout.frontend-layout')

@section('title','Forget Password')


@section('content')
<div class="form-gap"></div>
<div class="container">
    <div class="row d-flex justify-content-center m-2">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        <h2 class="text-center">Forgot Password?</h2>
                        <p>You can reset your password here.</p>
                        <div class="panel-body">
                            <form id="register-form" role="form" autocomplete="off" method="post" action="{{route('forgetPassword')}}" class=" form needs-validation"
                                  novalidate>
                                    @csrf
                                @if($message = Session::get('resetPassFail'))
                                    <div class="alert alert-danger">{{$message}}</div>
                                @endif
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                        <input id="email" name="email" placeholder="email address" class="form-control"  type="email" required>
                                        @include('error.error',['filed'=>'email'])
                                        <div class="invalid-feedback">
                                            Email Required
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button name="recover-submit" class="btn btn-lg btn-primary btn-block" data-toggle="modal" data-target="#myModal">Reset Password</button>
                                </div>

                                <input type="hidden" class="hide" name="token" id="token" value="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection