@extends('layout.backend-layout')

@section('title','Admin Profile')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-3">
            <form action="{{route('editAdminProfile')}}" method="post" class="needs-validation shadow p-5 col-md-12 col-lg-6"
                  novalidate>
                @csrf
                <h2 class="d-flex justify-content-center text-center">Account Details</h2>

                <div class="form-row">

                    <div class="col-md-12 col-12">
                        @if($message = Session::get('success'))
                            <div class="alert alert-success">{{$message}}</div>
                        @endif
                        <label>User Name</label>
                        <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 col-12">
                        <label>Address <span>*</span></label>
                        <input type="text" class="form-control" name="address" value="{{Auth::user()->address}}" required>
                        @include('error.error', ['filed' => 'address'])
                        <div class="invalid-feedback">
                            Address Required
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 col-12">
                        <label>Contact Number <span>*</span></label>
                        <input type="number" class="form-control" name="contact_number" value="{{Auth::user()->contact_number}}" required>
                        @include('error.error',['filed'=>'contact_number'])
                        <div class="invalid-feedback">
                            Contact Number required
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 col-12">
                        <label>Email <span>*</span></label>
                        <input type="email" class="form-control" name="email" value="{{Auth::user()->email}}" readonly>

                    </div>
                </div>
                <div class="form-row pt-3">
                    <div class="login_submit col-md-12">
                        <a>
                            <button type="submit" class="btn btn-primary col-md-4 mt-2">Save
                            </button>
                        </a>
                        <a href="{{route('changeAdminPassword')}}">
                            <button type="button" class="btn btn-info col-md-4 mt-2">Change Password
                            </button>
                        </a>
                    </div>
                </div>

            </form>
        </div>

    </div>

@endsection
