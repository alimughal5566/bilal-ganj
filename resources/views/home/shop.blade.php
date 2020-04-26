@extends('layout.frontend-layout')
@section('title','Shops')
@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{route('index')}}">Home</a></li>
                            <li>Shop</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->
    <!--shop  area start-->
    <div class="shop_area shop_reverse">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_inner">
                            <div class="widget_list widget_filter">
                                <h2>Filter by price</h2>
                                <form method="post" id="slider">
                                    @csrf
                                    <input type="hidden" name="start_price" id="amount_start"/>
                                    <input type="hidden" name="end_price" id="amount_end"/>
                                    <div id="slider-range">
                                    </div>
                                    <button type="submit">Filter</button>
                                    <input type="text" name="text" id="amount"/>

                                </form>
                            </div>
                            <div class="widget_list widget_categories car_brand">
                                <h2>Car Brands</h2>
                                <ul>
                                    <li>
                                        <input type="checkbox" name="city" value="64">
                                        <a href="#">Honda</a>
                                        <span class="checkmark"></span>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="wagon" value="63">
                                        <a href="#">Toyota</a>
                                        <span class="checkmark"></span>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="suzuki" value="62">
                                        <a href="#">Suzuki</a>
                                        <span class="checkmark"></span>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="hundai" value="75">
                                        <a href="#">Hyundai</a>
                                        <span class="checkmark"></span>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="nissan" value="66">
                                        <a href="#">Nissan</a>
                                        <span class="checkmark"></span>
                                    </li>

                                </ul>
                            </div>

                            <div class="widget_list widget_categories car_brand">
                                <h2>Bike Brands</h2>
                                <ul>
                                    <li>
                                        <input type="checkbox" name="honda" value="5">
                                        <a href="#">Atlas Honda</a>
                                        <span class="checkmark"></span>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="suzuki" value="6">
                                        <a href="#">Suzuki</a>
                                        <span class="checkmark"></span>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="united" value="7">
                                        <a href="#">United</a>
                                        <span class="checkmark"></span>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="roadPrince" value="8">
                                        <a href="#">RoadPrince</a>
                                        <span class="checkmark"></span>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="Yamaha" value="10">
                                        <a href="#">Yamaha</a>
                                        <span class="checkmark"></span>
                                    </li>

                                </ul>
                            </div>
                            <div class="widget_list widget_categories vendor_manufacturare">
                                <h2>Shop Brands</h2>
                                <ul>
                                    {{--{{dd($manufactures)}}--}}
                                    @foreach($manufactures as $manufacture)
                                    <li>
                                        <input type="checkbox" name="{{$manufacture->shop_name}}" value="{{$manufacture->id}}">
                                        <a href="#">{{$manufacture->shop_name}}</a>
                                        <span class="checkmark"></span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="shop_sidebar_banner">
                            <a href="#"><img src="{{asset('assets/frontend/img/bg/banner9.jpg')}}" alt=""></a>
                        </div>
                    </aside>
                    <!--sidebar widget end-->
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="shop_banner">
                        <img src="{{asset('assets/frontend/img/bg/banner8.jpg')}}" alt="">
                    </div>
                    <div class="shop_title">
                        <h1>shop</h1>
                    </div>
                    <div class="shop_toolbar_wrapper">
                        <div class="shop_toolbar_btn">

                            <button data-role="grid_3" type="button" class="active btn-grid-3" data-toggle="tooltip"
                                    title="3"></button>

                            <button data-role="grid_4" type="button" class=" btn-grid-4" data-toggle="tooltip"
                                    title="4"></button>

                            <button data-role="grid_list" type="button" class="btn-list" data-toggle="tooltip"
                                    title="List"></button>
                        </div>
                        <div class="">
                            @if(!isset($sortHide))
                                <form class="" action="#">
                                    <select name="orderby" class="short">
                                        <option selected hidden>Sort All Products</option>
                                        <option value="ascen">Sort by Ascending order</option>
                                        <option value="descen">Sort by Descending order</option>
                                        <option value="newness">Sort by newness</option>
                                        <option value="discount">Sort by Discount</option>
                                        <option value="low_to_high">Sort by price: low to high</option>
                                        <option value="higt_to_low">Sort by price: high to low</option>

                                    </select>
                                </form>
                            @endif

                        </div>

                        <div class="page_amount">
                            @if(count($allProducts)>9)
                                <p>Showing 1–9 of {{count($allProducts)}} results</p>
                            @endif
                        </div>

                    </div>
                    <!--shop toolbar end-->
                    <div id="my_tag">
                        @include('home.include.single-product')
                    </div>
                    <!--shop toolbar end-->
                    <!--shop wrapper end-->
                    <input type="hidden" name="hidden_page" id="hidden_page" value="1">
                    <input type="hidden" name="hidden_option" id="hidden_option" value="">
                </div>
            </div>
        </div>
    </div>

@endsection
