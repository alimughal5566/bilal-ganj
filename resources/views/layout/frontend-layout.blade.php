<!DOCTYPE html>
<html>
<head>

    <title>Bilal Ganj - @yield('title')</title>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/frontend/img/icon.png')}}">
    <link href="{{asset('assets/admin/vendor/fontawesome-free/css/all.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert-dev.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    @yield('styles')
</head>
<body>
<!--header area start-->
<header class="header_area">
    <!--header top start-->
    <div class="header_top">
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
                                                   href="{{route('userNotification',['notification'=>$notification])}}">
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
                                            <li><a href="{{route('userAccount')}}">My Account </a></li>
                                            @if(Auth::check() && Auth::user()->type==='bgshop')
                                            @else
                                                <li><a href="{{route('cart',Auth::user()->id)}}">Shopping Cart</a></li>
                                                <li><a href="{{route('wishlistView',Auth::user()->id)}}">Wishlist</a>
                                                </li>
                                            @endif
                                            <li><a href="{{route('logout')}}">Logout</a></li>
                                        </ul>
                                    </li>

                                    <li>{{Auth::user()->type==='bgshop'?'Vendor Dashboard':'Welcome - '.Auth::user()->name}}</li>
                                @endif
                                @if(!Auth::user())

                                    <li><a class="my_link" href="{{route('login')}}">Login/Register</a></li>
                                    <li><a class="my_link" href="{{route('registerAsVendor')}}">Request As Vendor</a>
                                    </li>

                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--header top start-->
    <!--header middel start-->
    <div class="header_middle">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-6">
                    <div class="logo">

                        <a href="{{route('index')}}"><img src="{{asset('assets/frontend/img/logo/icon2.png')}}" alt=""></a>

                    </div>
                </div>
                <div class="col-lg-9 col-md-6">
                    <div class="@if(Auth::user() && Auth::user()->type==='bgshop') middle @else middel_right @endif">
                        <div class="search-container position-relative">
                            <form action="{{route('searchProducts')}}" class="search_form" method="get">
                                <div class="search_box">
                                    <input name="name" class="search_product_name" value="{{request()->input('name')}}"
                                           placeholder="Search entire store here ..." type="text" autocomplete="off">
                                    <button><i class="ion-ios-search-strong"></i></button>
                                </div>
                                <div class="product_list"></div>
                            </form>
                        </div>
                        @if(Auth::check() && Auth::user()->type==='bgshop')
                        @else
                            <div class="middel_right_info">

                                <div class="header_wishlist">

                                    <a href="{{route('wishlistView',['id'=>Auth::user() ? Auth::user()->id:null])}}"><span
                                            class="lnr lnr-heart"></span> Wish list </a>
                                    <span class="wishlist_quantity">{{Auth::user()?$countItems:0}}</span>
                                </div>
                                <div class="mini_cart_wrapper">
                                    <a href="{{route('cart')}}"><span class="lnr lnr-cart"></span>My Cart </a>
                                    <span class="cart_quantity">{{Auth::check()?$cartQty:0}}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--header middel end-->
    <!--header bottom start-->
    <div class="header_bottom sticky-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="main_menu header_position">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light text-center">
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                                <div class="navbar-nav">
                                    @if(Auth::check() && Auth::user()->type==='bgshop')
                                        <li><a class="nav-item nav-link active" href="{{route('index')}}">home</a></li>
                                    @else
                                        <li><a class="nav-item nav-link" href="{{route('index')}}">Home</a></li>
                                        <li class="mega_items"><a class="nav-item nav-link" href="{{route('shop')}}">Shop</a>
                                        </li>
                                        <li><a class="nav-item nav-link" href="{{route('aboutUs')}}">About Us</a></li>
                                        <li><a class="nav-item nav-link" href="{{route('contactUs')}}"> Contact Us</a>
                                        </li>
                                    @endif
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--header bottom end-->

</header>
<!--header area end-->

@yield('content')

<!--call to action start-->
<section class="call_to_action">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="call_action_inner">
                    <div class="call_text">
                        <h3>We Have All<span> Spare Parts</span> at one place</h3>
                        <p>Also provide Cash on Delivery Service with reasonable price</p>
                    </div>
                    <div class="discover_now">
                        <a href="{{route('shop')}}">Shopping now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--call to action end-->

<!--footer area start-->
@if(Auth::check() && Auth::user()->type==='bgshop')
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
                            <a href="{{route('index')}}"><img src="{{asset('assets/frontend/img/logo/icon2.png')}}"
                                                              alt=""></a>
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
@else
    <footer class="footer_widgets">
        <div class="container">
            <div class="footer_top pb-3">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="widgets_container contact_us">
                            <div class="logo mb-3">
                                <a href="{{route('index')}}"><img src="assets/frontend/img/logo/icon2.png" alt=""></a>
                            </div>
                            <div class="footer_contact">
                                <h5>
                                    Bilal Ganj is a famous market in Lahore,
                                    Punjab, Pakistan, where mostly used vehicles parts are
                                    sold at cheap rates.
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="widgets_container widget_menu">
                            <h3>Information</h3>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="widgets_container widget_menu">
                            <h3>Extras</h3>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="#">Order History</a></li>
                                    <li><a href="#">Wish List</a></li>
                                    <li><a href="{{route('cart')}}">Cart</a></li>
                                    <li><a href="#">FAQ</a></li>
                                </ul>
                            </div>
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
                            <p class="heading lead">Alert</p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</span>
                            </button>
                        </div>

                        <!--Body-->
                        <div class="modal-body">
                            <div class="text-center">
                                <i class="lnr lnr-heart fa-4x mb-3 animated rotateIn color"></i>
                                <h4 class="color">If you want to save product<br> then login/register and save product
                                    into
                                    your wish List.</h4>
                            </div>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">

                            <a type="button" class="btn btn-block bg-success" href="{{route('login')}}"> Login now <i
                                    class="fas fa-sign-in-alt ml-1 white-text"></i></a>
                            <a type="button" class="btn btn-block bg-secondary wave-effect mt-0" data-dismiss="modal">No,
                                thanks</a>
                        </div>
                    </div>
                    <!--/.Content-->
                </div>
            </div>
            <!-- Central Modal Medium Success-->

            <!-- Central Modal Medium Success -->
            <div class="modal fade" id="centralModalSuccessCart" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-notify modal-success" role="document">
                    <!--Content-->
                    <div class="modal-content">
                        <!--Header-->
                        <div class="modal-header">
                            <p class="heading lead">Alert</p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</span>
                            </button>
                        </div>

                        <!--Body-->
                        <div class="modal-body">
                            <div class="text-center">
                                <i class="lnr lnr-cart fa-4x mb-3 animated rotateIn color"></i>
                                <h4 class="color mt-2">If you want to add Product into your cart<br> please
                                    login/register
                                </h4>
                            </div>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">

                            <a type="button" class="btn btn-block bg-success" href="{{route('login')}}"> Login now <i
                                    class="fas fa-sign-in-alt ml-1 white-text"></i></a>
                            <a type="button" class="btn btn-block bg-secondary wave-effect mt-0" data-dismiss="modal">No,
                                thanks</a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Central Modal Medium Success-->
        </div>
    </footer>
@endif
<!--footer area end-->
<script src="{{asset('assets/js/jquery-3.3.1.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/plugins.js')}}"></script>
<script src="{{asset('assets/frontend/js/main.js')}}"></script>
<script src="{{asset('assets/js/sweetalert-dev.js')}}"></script>
@include('layout.include.const')
<script src="{{asset('assets/js/custom.js')}}"></script>
@yield('scripts')
</body>
</html>
