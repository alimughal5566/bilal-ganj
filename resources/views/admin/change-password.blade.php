@extends('layout.backend-layout')

@section('title','Admin Profile')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-3">
            <form action="{{route('adminChangePassword')}}" method="post" class="needs-validation shadow p-5 col-md-12 col-lg-6"
                  novalidate>
                @csrf
                <h2 class="d-flex justify-content-center text-center">Change Password</h2>

                <div class="form-row">
                    <div class="col-md-12 col-12">
                        @if($message = Session::get('success'))
                            <div class="alert alert-success">{{$message}}</div>
                        @endif
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <label>Old Password <span>*</span></label>
                        <input type="password" class="form-control" name="old_password" required>
                            @include('error.error',['filed'=>'old_password'])
                            @if($message = Session::get('error'))
                                <div class="text-danger">{{$message}}</div>
                            @endif
                        <div class="invalid-feedback">
                            Old Password Required
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 col-12">
                        <label>New Password <span>*</span></label>
                        <input type="password" class="form-control" name="password" required>
                        @include('error.error', ['filed' => 'password'])
                        <div class="invalid-feedback">
                           New Password Required
                        </div>
                    </div>
                </div>
                <div class="form-row pt-3">
                    <div class="login_submit col-md-12">
                        <a>
                            <button type="submit" class="btn btn-primary col-md-3 mt-2">Change
                            </button>
                        </a>
                    </div>
                </div>
                <a href="{{route('adminProfile')}}" style="text-decoration: none">Back to Account</a>
            </form>
        </div>
    </div>
@endsection