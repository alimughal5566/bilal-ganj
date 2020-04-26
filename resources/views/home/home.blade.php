@extends('layout.frontend-layout')

@section('title','Connect Spare Parts Vendor And Customer')

@section('content')
        @if($banner)

            <section class="slider_section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                                <a href="#"><img class="w-100 mb-5 banner_image" style="height: 120px" src="{{asset('assets/ads-images/'.$banner['image'])}}"></a>
                        </div>

                    </div>
                </div>
            </section>
        @endif
    <!--slider area start-->
    <section class="slider_section mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="categories_menu">
                        <div class="categories_title">
                            <h2 class="categori_toggle">Browse categories</h2>
                        </div>
                        <div class="categories_menu_toggle">
                            <ul>
                                <li class="menu_item_children categorie_list"><a href="#">Bikes <i
                                            class="fa fa-angle-right"></i></a>
                                    <ul class="categories_mega_menu">
                                        @foreach($bikes as $bike)
                                            <li class="menu_item_children"><a
                                                    href="#">{{$bike['name']}}
                                                </a>
                                                <div class="categorie_sub_menu">
                                                    <ul>
                                                        @foreach($honda as $hnd)
                                                            @if($bike->id===5)
                                                                <li>
                                                                    <a href="{{route('selectCat',['id'=>$hnd->id])}}">{{$hnd['name']}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        @foreach($suzuki as $szki)
                                                            @if($bike->id===6)
                                                                <li>
                                                                    <a href="{{route('selectCat',['id'=>$szki->id])}}">{{$szki['name']}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        @foreach($united as $untd)
                                                            @if($bike->id===7)
                                                                <li>
                                                                    <a href="{{route('selectCat',['id'=>$untd->id])}}">{{$untd['name']}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        @foreach($road as $prince)
                                                            @if($bike->id===8)
                                                                <li>
                                                                    <a href="{{route('selectCat',['id'=>$prince->id])}}">{{$prince['name']}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        @foreach($metro as $mtr)
                                                            @if($bike->id===9)
                                                                <li>
                                                                    <a href="{{route('selectCat',['id'=>$mtr->id])}}">{{$mtr['name']}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        @foreach($yamaha as $yam)
                                                            @if($bike->id===10)
                                                                <li>
                                                                    <a href="{{route('selectCat',['id'=>$yam->id])}}">{{$yam['name']}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="menu_item_children categorie_list"><a href="#"> Cars<i
                                            class="fa fa-angle-right"></i></a>
                                    <ul class="categories_mega_menu">
                                        @foreach($cars as $car)
                                            <li class="menu_item_children"><a href="#">{{$car['name']}}</a>
                                                <div class="categorie_sub_menu">
                                                    <ul>
                                                        @foreach($suzukiCar as $szCar)
                                                            @if($car->id===62)
                                                                <li>
                                                                    <a href="{{route('selectCat',['id'=>$szCar->id])}}">{{$szCar['name']}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        @foreach($toyotaCar as $tytCar)
                                                            @if($car->id===63)
                                                                <li>
                                                                    <a href="{{route('selectCat',['id'=>$tytCar->id])}}">{{$tytCar['name']}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        @foreach($hondaCar as $honCar)
                                                            @if($car->id===64)
                                                                <li>
                                                                    <a href="{{route('selectCat',['id'=>$honCar->id])}}">{{$honCar['name']}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        @foreach($daihatsuCar as $datsuCar)
                                                            @if($car->id===65)
                                                                <li>
                                                                    <a href="{{route('selectCat',['id'=>$datsuCar->id])}}">{{$datsuCar['name']}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        @foreach($nissanCar as $nssCar)
                                                            @if($car->id===66)
                                                                <li>
                                                                    <a href="{{route('selectCat',['id'=>$nssCar->id])}}">{{$nssCar['name']}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        @foreach($audiCar as $adiCar)
                                                            @if($car->id===67)
                                                                <li>
                                                                    <a href="{{route('selectCat',['id'=>$adiCar->id])}}">{{$adiCar['name']}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @if(isset($slot1))
                        <div class="my-img">
                            <a href="#"><img src="{{asset('assets/ads-images/'.$slot1['image'])}}" alt="there is an img"></a>
                        </div>
                        @endif
                </div>
                <div class="col-lg-7 col-md-12">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active position-relative">
                                <img class="d-block w-100" src="{{asset('assets/frontend/img/slider/slider1.jpg')}}"
                                     alt="First slide">
                                <div class="slider_content position-absolute">
                                    <h2>Top Quality</h2>
                                    <h1>The Parts of Turbocharger</h1>
                                    <a class="button" href="{{route('shop')}}">shopping now</a>
                                </div>
                            </div>
                            <div class="carousel-item position-relative">
                                <img class="d-block w-100" src="{{asset('assets/frontend/img/slider/slider2.jpg')}}"
                                     alt="Second slide">
                                <div class="slider_content position-absolute">
                                    <h2>Height - Quality</h2>
                                    <h1>The Parts Of shock Absorbers & Brake Kit</h1>
                                    <a class="button" href="{{route('shop')}}">shopping now</a>
                                </div>
                            </div>
                            <div class="carousel-item position-relative">
                                <img class="d-block w-100" src="{{asset('assets/frontend/img/slider/slider3.jpg')}}"
                                     alt="Third slide">
                                <div class="slider_content position-absolute">
                                    <h2>Engine Oils</h2>
                                    <h1>Top Quality Oil For Every Vehicle</h1>
                                    <a class="button" href="{{route('shop')}}">shopping now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if( isset($slot2))
                    <div class="col-lg-2 col-md-12 right_slot">
                        <a href="#"><img src="{{asset('assets/ads-images/'.$slot2['image'])}}" alt="there is an img"></a>
                    </div>
                @endif
            </div>
        </div>

    </section>

    <!--slider area end-->

    <!--shipping area start-->
    <section class="shipping_area mb-50">
        <div class="container">
            <div class=" row">
                <div class="col-12">
                    <div class="shipping_inner">
                        <div class="single_shipping">
                            <div class="shipping_icone">
                                <img src="{{asset('assets/frontend/img/about/shipping1.png')}}" alt="">
                            </div>
                            <div class="shipping_content">
                                <h2>Cash on Delivery</h2>
                                <p>Provide Cash on Delivery</p>
                            </div>
                        </div>
                        <div class="single_shipping">
                            <div class="shipping_icone">
                                <img src="{{asset('assets/frontend/img/about/shipping2.png')}}" alt="">
                            </div>
                            <div class="shipping_content">
                                <h2>Support 24/7</h2>
                                <p>Contact us 24 hours a day</p>
                            </div>
                        </div>
                        <div class="single_shipping">
                            <div class="shipping_icone">
                                <img src="{{asset('assets/frontend/img/about/shipping3.png')}}" alt="">
                            </div>
                            <div class="shipping_content">
                                <h2>100% Money Back</h2>
                                <p>You have 7 days to Return</p>
                            </div>
                        </div>
                        <div class="single_shipping">
                            <div class="shipping_icone">
                                <img src="{{asset('assets/frontend/img/about/shipping4.png')}}" alt="">
                            </div>
                            <div class="shipping_content">
                                <h2>Payment Secure</h2>
                                <p>We ensure secure payment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--shipping area end-->

    @include('home.include.home-products')

@endsection
@section('script')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>--}}
@endsection






