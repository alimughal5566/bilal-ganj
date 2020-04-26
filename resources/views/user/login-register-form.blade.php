@extends('layout.frontend-layout')

@section('title','Login/Register')

@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{route('index')}}">home</a></li>
                            <li>Login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!-- customer login start -->
    <div class="customer_login mt-32">
        <div class="container">
            <div class="row">
                <!--login area start-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form">
                        <h2 class="mb-2">login</h2>
                        <small class="text-danger">*All Fields are Required</small>
                        <form name="login_form" method="post" action="{{route('authUser')}}" class="needs-validation"
                              novalidate>
                            @if($message = Session::get('authFailed'))
                                <div class="alert alert-danger">{{$message}}</div>
                            @elseif($message = Session::get('resetPass'))
                                <div class="alert alert-success">{{$message}}</div>
                            @elseif($message = Session::get('passwordChanged'))
                                <div class="alert alert-success">{{$message}}</div>
                            @elseif($message = Session::get('emailVerify'))
                                <div class="alert alert-success">{{$message}}</div>
                            @elseif($message = Session::get('blocked'))
                                <div class="alert alert-danger">{{$message}}</div>
                            @endif
                            @csrf
                            <p>
                            <div>
                                <label>Email</label>
                                <input type="email" name="Email" class="form-control" value="{{old('Email')}}" required>
                                @include('error.error',['filed'=>'Email'])
                                <div class="invalid-feedback">
                                    Valid Email Required
                                </div>
                            </div>
                            </p>
                            <p>
                            <div>
                                <label>Passwords</label>
                                <input type="password" name="Password" class="form-control" required>
                                @include('error.error',['filed'=>'Password'])
                                @if($message = Session::get('message'))
                                    <div class="text-danger">{{$message}}</div>
                                @endif
                                <div class="invalid-feedback">
                                    Password is Required
                                </div>
                            </div>
                            </p>
                            <div class="login_submit">
                                <a href="{{route('forgetPasswordView')}}"><b>Forget your password?</b></a>
                                <button type="submit">login</button>
                            </div>
                            <div class="text-center my-4 font-weight-bold border-bottom position-relative">
                                <span class="position-absolute">
                                    OR
                                </span>
                            </div>
                            <span class="login_via">
                                <a href="{{route('redirect',['provider'=>'google'])}}">
                                    <div class="google_login mt-3 py-2 text-center text-white bg-danger rounded"><i
                                                class="fa fa-google mr-2"></i>
                                        <label>Login With Google</label>
                                    </div>
                                </a>
                                <a href="{{route('redirect',['provider'=>'facebook'])}}">
                                    <div class="facebook_login mt-3 py-2 text-center text-white bg-primary rounded"><i
                                                class="fa fa-facebook-official mr-2"></i>
                                        <label>Login With Facebook</label>
                                    </div>
                                </a>
                                <a href="{{route('redirect',['provider'=>'instagram'])}}">
                                    <div class="instagram_login mt-3 py-2 text-center text-white bg-primary rounded"><i
                                                class="fa fa-instagram mr-2"></i>
                                        <label>Login With Instagram</label>
                                    </div>
                                </a>
                                <a href="{{route('redirect',['provider'=>'linkedin'])}}">
                                    <div class="twitter_login mt-3 py-2 text-center text-white bg-info rounded"><i
                                                class="fa fa-linkedin mr-2"></i>
                                        <label>Login With LinkedIn</label>
                                    </div>
                                </a>
                            </span>
                        </form>
                    </div>
                </div>
                <!--login area start-->

                <!--register area start-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form register">
                        <h2 class="mb-2">Register</h2>
                        <small class="text-danger">*All Fields are Required</small>
                        <form name="register_form" method="post" action="{{route('registerAsUser')}}"
                              class="needs-validation" novalidate>
                            @if($message = Session::get('registerAlert'))
                                <div class="alert alert-success">{{$message}}</div>
                            @endif
                            @csrf
                            <p>
                            <div>
                                <label>User Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                       required>
                                @include('error.error', ['filed' => 'name'])
                                <div class="invalid-feedback">
                                    Full Name Required
                                </div>
                            </div>
                            </p>
                            <p>
                            <div>
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" value="{{ old('email') }}"
                                       required>
                                @include('error.error', ['filed' => 'email'])
                                <div class="invalid-feedback">
                                    Email Required
                                </div>
                            </div>
                            </p>
                            <p>
                            <div>
                                <label>Passwords</label>
                                <input type="password" name="password" class="form-control" required>
                                @include('error.error', ['filed' => 'password'])
                                <div class="invalid-feedback">
                                    Password Required
                                </div>
                            </div>
                            </p>
                            <p>
                            <div>
                                <label>Contact No</label>
                                <input type="Number" name="contact_number" min="0" class="form-control"
                                       value="{{ old('contact_number') }}" required>
                                @include('error.error', ['filed' => 'contact_number'])
                                <div class="invalid-feedback">
                                    Contact No Required
                                </div>
                            </div>
                            </p>
                            <p>
                            <div>
                                <label>Address</label>
                                <textarea rows="3" id="refrence_set" value="" data-toggle="modal" data-target="#myModal"
                                          cols="120" class="controls form-control size location"
                                          placeholder="Enter location" name="address"
                                          required>{{old('address')}}</textarea>
                                <input type="hidden" value="31.5204" id="lati" name="latitude">
                                <input type="hidden" value="74.3587" id="longi" name="longitude">
                                @include('error.error', ['filed' => 'address'])
                                <div class="invalid-feedback">
                                    Address Required
                                </div>
                            </div>
                            </p>
                            <div class="login_submit">
                                <button type="submit">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--register area end-->

                @include('partial.location-modal')
            </div>
        </div>
    </div>
    <!-- customer login end -->
@endsection
@section('scripts')
    <script src="{{asset('assets/js/map.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqSTkzPn8PpJBY3Pclu-TTjmGDLzqKMD4&libraries=places&callback=initialize"
            async defer></script>
@endsection