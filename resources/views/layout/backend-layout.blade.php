<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bilal Ganj - @yield('title')</title>
    @yield('styles')
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/frontend/img/icon.png')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awsome.min.css')}}">
    <link href="{{asset('assets/admin/vendor/fontawesome-free/css/all.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/admin/vendor/datatables/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link href="{{asset('assets/admin/css/sb-admin.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/zebra_datepicker.min.css')}}">
{{--    <link rel="stylesheet" href="{{asset('assets/css/chosen.css')}}">--}}
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <style>
        .clr {
            color: white;
            font-size: 23px;
        }
        @yield('css')
    </style>
</head>
<body id="page-top">
<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <a class="navbar-brand mr-1" href=""><i>Bilal_Ganj</i></a>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>
    <div class="ml-auto">
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    @if($count)
                        <span class="badge badge-danger">
                        {{$count}}
                        </span>
                    @endif
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">

                    @if($notifications->count() === 0)
                        <span class="dropdown-item">No New Notification</span>
                    @endif
                    @if($notifications->count() != 0)
                        <a href="{{route("markAsRead")}}" class="btn btn-link text-decoration-none">Mark All As Read</a>
                    @endif
                    @foreach($notifications as $notification)
                        <a class="{{$notification->status===0?'far fa-envelope ':'far fa-envelope-open'}} dropdown-item"
                           href="{{route('responseToNotification',['notification'=>$notification])}}">
                            <span class="pl-2">{{$notification->message}}</span>
                        </a>
                    @endforeach

                </div>
            </li>

            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{route('adminProfile')}}">Account</a>
                    <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                </div>
            </li>

        </ul>
    </div>

</nav>

<div id="wrapper">
    @include('admin.includes.side-navbar')
    @yield('content')
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</div>
<script src="{{asset('assets/admin/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<script src="{{asset('assets/admin/vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/admin/vendor/datatables/dataTables.bootstrap4.js')}}"></script>

<script src="{{asset('assets/admin/js/sb-admin.min.js')}}"></script>
<script src="{{asset('assets/admin/js/demo/datatables-demo.js')}}"></script>
<script src="{{asset('assets/admin/js/demo/chart-area-demo.js')}}"></script>
<script src="{{asset('assets/admin/js/zebra_datepicker.min.js')}}"></script>
<script src="{{asset('assets/admin/js/zebra_datepicker.src.js')}}"></script>

@include('layout.include.const')
<script src="{{asset('assets/js/chosen.jquery.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/admin/js/custome.js')}}"></script>

@yield('scripts')
</body>
</html>
