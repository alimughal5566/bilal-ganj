<!DOCTYPE html>
<html>
<head>
    <title>Bilal Ganj</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/frontend/img/icon.png')}}">
    <link href="{{asset('assets/admin/vendor/fontawesome-free/css/all.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">

</head>
<body>
<header class="header_area">
    <!--header top start-->
    <div class="header_top">
        <div class="container">
            <div class="top_inner">
                <div class="row align-items-center p-2">
                    <div class="col-lg-6 col-md-6">
                        <div class="logo">

                            <a href="{{route('index')}}"><img class="h-25 w-25" src="{{asset('assets/frontend/img/logo/icon2.png')}}" alt=""></a>

                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="top_right text-right">
                            <ul>
                                <li><h3>Bilal Ganj</h3></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--header top start-->
</header>
<div class="container">
    <div class="row d-flex justify-content-center m-5">
        <div class="col-sm-8">

            <form autocomplete="off" method="post" action="{{route('forgetPasswordDone')}}" class=" form needs-validation shadow p-5"  novalidate >
                @csrf

                <input type="hidden" name="email" value="{{$email}}">
                <h3 class="text-center"><i class="fas fa-unlock-alt fa-4x"></i></h3>
                <h2 class="text-center">Reset Password?</h2>
                <label>New Password</label>
                <div class="form-group pass_show">
                    <input type="password"  class="form-control" name="password" placeholder="New Password" required value="{{old('password')}}">
                    @include('error.error',['filed'=>'password'])
                    <div class="invalid-feedback">
                        This Field Required
                    </div>
                </div>
                <label>Confirm Password</label>
                <div class="form-group pass_show">
                    <input type="password"  class="form-control" name="confirmPassword" placeholder="Confirm Password" required value="{{old('confirmPassword')}}">
                    @include('error.error',['filed'=>'confirmPassword'])
                    <div class="invalid-feedback">
                        This Field Required
                    </div>
                </div>
                @if($message=Session()->get('match'))
                        <div class="alert alert-danger">{{$message}}</div>
                @endif
                <button class="btn btn-primary"><b>  Done </b></button>
            </form>

        </div>
    </div>
</div>

<!--footer area start-->
<footer class="footer_widgets">
    <div class="container">
        <div class="footer_top pb-3">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="widgets_container contact_us">
                        <div class="logo mb-3">
                            <a href="{{route('index')}}"><img class=" h-25 w-50" src="{{asset('assets/frontend/img/logo/icon2.png')}}" alt=""></a>
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
                            <h4 class="color">If you want to save product<br> then login/register and save product into
                                your wish List.</h4>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">

                        <a type="button" class="btn btn-block bg-success" href="{{route('login')}}"> Login now <i
                                    class="fas fa-sign-in-alt ml-1 white-text"></i></a>
                        <a type="button" class="btn btn-block bg-secondary wave-effect" data-dismiss="modal">No,
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
<script src="{{asset('assets/js/custom.js')}}"></script>
@yield('scripts')
</body>
</html>