@extends('layout.frontend-layout')

@section('title','Vendor Registeration')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-clockpicker.css')}}">
@endsection
@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{route('index')}}">home</a></li>
                            <li>Request As Vendor</li>
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
            <div class="row justify-content-center">

                <!--register area start-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form register">
                        <h2>Request to Register As Vendor</h2>
                        @if(Session()->has('success'))
                            <div class="alert alert-success">
                                {{session()->get('success')}}
                            </div>
                        @endif
                        <form action="{{route('saveVendor')}}" method="post" class="needs-validation" novalidate>
                            @csrf
                            <p>
                            <div>
                                <label>User Name </label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                                @include('error.error', ['filed' => 'name'])
                                <div class="invalid-feedback">
                                    Name Required
                                </div>
                            </div>
                            </p>
                            <p>
                            <div>
                                <label>Email </label>
                                <span class="text-danger">*</span>
                                <input type="email" class="form-control" name="email" value="{{old('email')}}" required>
                                @include('error.error', ['filed' => 'email'])
                                <div class="invalid-feedback">
                                    Valid Email Required
                                </div>
                            </div>
                            </p>
                            <p>
                            <div>
                                <label>Password </label>
                                <span class="text-danger">*</span>
                                <input type="password" class="form-control" name="password" required>
                                @include('error.error', ['filed' => 'password'])
                                <div class="invalid-feedback">
                                    Password Required
                                </div>
                            </div>
                            </p>
                            <p>
                            <div>
                                <label>Contact Number</label>
                                <span class="text-danger">*</span>
                                <input type="number" class="form-control" name="contact_number"
                                       value="{{old('contact_number')}}" required>
                                @include('error.error', ['filed' => 'contact_number'])
                                <div class="invalid-feedback">
                                    Valid Contact Number Required
                                </div>
                            </div>
                            </p>
                            <p>
                            <div>
                                <label>Shop Name</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" name="shop_name" value="{{old('shop_name')}}"
                                       required>
                                @include('error.error', ['filed' => 'shop_name'])
                                <div class="invalid-feedback">
                                    Shop Name Required
                                </div>
                            </div>
                            </p>

                            <p>
                            <div>
                                <div>
                                    <label>Address</label>
                                    <span class="text-danger">*</span>
                                </div>
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

                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                    <div>
                                        <label>Opening Time</label>
                                        <div class="">
                                            <input type="text" class="form-control clockpicker" name="opening_time"
                                                   value="{{old('opening_time')}}">
                                        </div>
                                    </div>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                    <div>
                                        <label>Closing Time</label>
                                        <div class="">
                                            <input type="text" class="form-control clockpicker" name="closing_time"
                                                   value="{{old('closing_time')}}">
                                        </div>
                                    </div>
                                    </p>
                                </div>
                            </div>
                            <div class="login_submit">
                                <button type="submit">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--register area end-->
            </div>
        </div>
    </div>
    <!-- customer login end -->
    @include('partial.location-modal')

@endsection
@section('scripts')
    <script src="{{asset('assets/js/bootstrap-clockpicker.js')}}"></script>
    <script>
        $('.clockpicker').clockpicker();
    </script>
    <script src="{{asset('assets/js/map.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqSTkzPn8PpJBY3Pclu-TTjmGDLzqKMD4&libraries=places&callback=initialize"
            async defer></script>
@endsection
