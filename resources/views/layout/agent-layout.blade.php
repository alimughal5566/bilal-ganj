<!DOCTYPE html>
<html>
<head>

    <title>Bilal Ganj - @yield('title')</title>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/frontend/img/icon.png')}}">
    <link href="{{asset('assets/admin/vendor/fontawesome-free/css/all.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    @yield('styles')
</head>
<body>

<!--header area start-->
<header class="header_area">
    <div class="agent_header">
        <div class="container">
            <div class="top_inner">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">

                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="top_right text-right">
                            <ul>
                                @if(Auth::check())
                                    <li class="top_links"><a href="#"><i class="fa fa-bell"></i></a>
                                        @if($count)
                                            <span class="badge badge-danger">
                                                    {{$count}}
                                            </span>
                                        @endif
                                        <span class="notify_style">
                                        <ul class="dropdown_links w-auto">
                                            <li>
                                                <div class="dropdown-menu-right"
                                                     aria-labelledby="alertsDropdown">
                                                    @if($notifications->count() === 0)
                                                        <span class="dropdown-item">No New Notification</span>
                                                    @endif
                                                    @if($notifications->count() != 0)
                                                        <a href="{{route('markAsRead')}}"
                                                           class="btn btn-link d-flex justify-content-start text-decoration-none">Mark All As
                                                            Read</a>
                                                    @endif
                                                    @foreach($notifications as $notification)
                                                        <a class="{{$notification->status===0?'fa fa-envelope-o ':'fa fa-envelope-open-o'}} dropdown-item"
                                                           href="{{route('agentNotification',['notification'=>$notification])}}">
                                                            <span class="pl-2">{{$notification->message}}</span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </li>
                                       </ul>
                                    </span>
                                    </li>
                                    <li class="top_links"><a href="#"><i class="ion-android-person"></i> My Account<i
                                                class="ion-ios-arrow-down"></i></a>
                                        <ul class="dropdown_links">
                                            <li><a href="{{route('agentPanel')}}">My Account </a></li>
                                            <li><a href="{{route('logout')}}">Logout</a></li>
                                        </ul>
                                    </li>
                                    <li>Agent Dashboard</li>
                                @endif
                                @if(!Auth::user())
                                    <li><a class="my_link" href="{{route('login')}}">Login/Register</a></li>
                                    <li><a class="my_link" href="{{route('registerAsVendor')}}">Register As Vendor</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--header area end-->
<!--header middel start-->
<div class="header_middle">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-6">
                <div class="logo">

                    <a href="{{route('index')}}"><img src="{{asset('assets/frontend/img/logo/icon2.png')}}" alt=""></a>

                </div>
            </div>
            <div class="col-lg-9 col-md-6 ">

            </div>
        </div>
    </div>
</div>
<!--header middel end-->
<!--header bottom start-->
<div class="header_bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="main_menu header_position">
                    <nav>
                        <ul class="pl-0">
                        @section('breadCrumbs')
                            <!--breadcrumbs area start-->
                                <div class="breadcrumbs_area">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="breadcrumb_content py-3">
                                                    <ul class="pl-0">
                                                        <li><a href="{{route('agentPanel')}}">home</a></li>
                                                        <li>@yield('content')</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--breadcrumbs area end-->
                            @show
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!--header bottom end-->

<section class="main_content_area">
    <div class="container">
        <div class="account_dashboard">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <!-- Nav tabs -->
                    <div class="dashboard_tab_button">
                        <ul role="tablist" class="nav flex-column dashboard-list" id="myTab">
                            <li><a href="{{route('agentPanel')}}" class="nav-link">
                                    Vendor's List</a></li>
                            <li><a href="{{route('vendorRequest')}}" class="nav-link">
                                    Vendor's Request</a>
                            </li>
                            <li><a href="{{route('agentAccount')}}" class="nav-link">Account
                                    details</a></li>
                            <li><a href="{{route('addCategoryView')}}" class="nav-link">Add Category</a></li>
                            <li><a href="#" class="nav-link">Addresses</a></li>
                            <li><a href="{{route('logout')}}" class="nav-link">logout</a></li>
                        </ul>
                    </div>
                </div>
                @yield('rightPane')
            </div>
        </div>
    </div>
</section>

<!--footer area start-->
<footer class="footer_widgets">
    <div class="container">
        <div class="footer_top pb-3">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="widgets_container contact_us">
                        <h3>About Me</h3>
                        <div class="footer_contact">
                            <h5>
                                Bilal Ganj is a famous market in Lahore,
                                Punjab, Pakistan, where mostly used vehicles parts are
                                sold at cheap rates.
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="logo mb-3 text-center">
                        <a href="{{route('index')}}"><img src="{{asset('assets/frontend/img/logo/icon2.png')}}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="widgets_container footer_contact">
                        <h3>Address</h3>
                        <h5>
                            Bilal Ganj market is situated
                            close to the shrine of the Sufi saint <b>Data Ganj Baksh (Ali Hujwiri)</b>.
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="copyright_area">
                        <p>Copyright &copy; 2019 <a href="#">Bilal Ganj</a> All Right Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Central Modal Medium Success -->
        <div class="modal fade" id="centralModalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-notify modal-success" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading lead">Modal Success</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="lnr lnr-heart fa-4x mb-3 animated rotateIn"></i>
                            <p>If you want to save product then login and save product into your wish List.</p>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">

                        <a type="button" class="btn btn-success" href="{{route('login')}}"> Login now <i
                                class="fas fa-sign-in-alt ml-1 white-text"></i></a>
                        <a type="button" class="btn btn-outline-success waves-effect" data-dismiss="modal">No,
                            thanks</a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- Central Modal Medium Success-->
    </div>
</footer>
<!--footer area end-->

<script src="{{asset('assets/js/jquery-3.3.1.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/plugins.js')}}"></script>
<script src="{{asset('assets/frontend/js/main.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
@yield('scripts')
</body>
</html>
