@extends('layout.backend-layout')
@section('title','Admin - Agent Registeration')

@section('content')
    <div class="container-fluid">
        <div class="customer_login mt-3">

            <div class="row justify-content-center">

                <!--register area start-->
                <div class="">
                    <div class="account_form register">

                        @if(Session()->has('success'))
                            <div class="alert alert-success">
                                {{session()->get('success')}}
                            </div>
                        @endif
                        <form action="{{route('saveAgent')}}" method="post" class="needs-validation shadow p-5"
                              novalidate>
                            @csrf
                            <h2 class="d-flex justify-content-center">ADD Agent</h2>
                            @include('admin.includes.agent-form')
                            <div class="form-row pt-3">
                                <div class="login_submit">
                                    <button type="submit" class="btn btn-block btn-success">Add Agent</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--register area end-->
                @include('partial.admin-location-modal')
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('assets/js/map.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqSTkzPn8PpJBY3Pclu-TTjmGDLzqKMD4&libraries=places&callback=initialize"
            async defer></script>
@endsection