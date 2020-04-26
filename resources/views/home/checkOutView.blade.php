@extends('layout.frontend-layout')
@section('title','Ceckout')
@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{route('index')}}">home</a></li>
                            <li><a href="{{route('cart')}}">Shopping Cart</a></li>
                            <li>CheckOut</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->
    <span class="main_body">
        <div class="shopping_cart_area">
            <div class="container margin_bottom">

                <div class="bg-grey p-3 mb-5">
                        <h3>Order Details</h3>
                    </div>
                <div class="row">
                    <div class="col-12 col-lg-5 col-md-12">
                    <div class="coupon_code right">
                        <div class="coupon_inner">
                            <div class="mb-2">
                                <b><p class="mb-1">Location</p></b>
                                <i class="fas fa-map-marker-alt"></i>
                                @if(Auth::user()->address)
                                    <span class="pl-2">{{Auth::user()->address}}</span>
                                @else
                                    <a class="float-right" href="{{route('userAccount')}}"><span
                                            class="pl-2 text-danger">Please Set your Billing Address</span></a>
                                @endif
                            </div>
                            <div class="border-bottom"></div>
                            <div class="my-2">
                                <h4 class="mb-1">Order Summary</h4>
                            </div>
                            <div class="cart_subtotal">
                                <p>Subtotal ({{$count}} Items)</p>
                                <p class="cart_amount">RS. <span
                                        class="amount mr-0">{{$total}}</span></p>
                            </div>
                            <div class="cart_subtotal">
                                <p>Shipping Fee</p>
                                <p class="cart_amount float-right">RS. <span
                                        class="mr-0">35</span></p>
                            </div>
                            <div class="border-bottom"></div>
                            <div class="cart_subtotal my-2">
                                <p>Total</p>
                                <p class="cart_amount float-right">RS. <span
                                        class="mr-0">{{$orderAmount}}</span></p>
                            </div>
                            <div class="d-flex">
                                <form method="post" action="{{route('placeOrder')}}">
                                    @csrf
                                    <input type="hidden" name="total" value="{{$orderAmount}}">
                                    <input type="hidden" name="latitude" id="latitude"
                                           value="{{Auth::user()->latitude}}">
                                    <input type="hidden" name="longitude" id="longitude"
                                           value="{{Auth::user()->longitude}}">
                                    <input type="hidden" name="vendorLati" id="vendorLati" value="31.5803">
                                    <input type="hidden" name="vendorLongi" id="vendorLongi" value="74.3012">
                                    <input type="hidden" name="estimated_time" class="distance_field" value="">
                                    <button class="btn btn-primary mr-2">Cash On Delivery</button>

                                </form>
                                <a href="{{route('stripe',['total'=>$orderAmount])}}">
                                    <button class="btn btn-secondary pay_btn">Online Payment</button>
                                </a>
                             </div>
                        </div>
                    </div>
                </div>
                    <div class="col-12 col-lg-7 col-md-12 margint_top">
                    <div class="show_products">
                        <table class="table table-responsive">
                            <thead class="bg-grey">
                            <tr class="no_wrap">
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($products))
                                @php
                                    $total = 0;
                                @endphp
                                @foreach($products as $product)
                                    @php
                                        $media = $product->media()->first();
                                        $getCart = $product->carts()->wherePivot('product_id', $product->id)->first()->pivot;
                                        $amount = $product->ucp;
                                        $amount += $amount/100 * $product->discount;
                                    @endphp
                                    <tr class="no_wrap">
                                <input type="hidden" name="product_id"
                                       value="{{$product->id}}">
                                        <td class="product_thumb">
                                            <a href="{{route('productDetail',['id'=>$product->id])}}"><img
                                                    ho class="image_size"
                                                    src="{{asset('assets/images/'.$media->image)}}"
                                                    alt="">
                                            </a>
                                        </td>
                                        <td class="product_name">{{$product->name}}</td>
                                        <td class="product-price">
                                            <span class="text-danger">RS. {{$product->ucp}}</span>
                                            <br>
                                            <div class="price_box">
                                                <span class="old_price"><small>RS. {{round($amount)}}</small></span>
                                            </div>
                                            <small class="">-{{$product->discount}}%</small>
                                        </td>
                                        <td class="product_quantity">
                                            {{$getCart->quantity}}
                                        </td>
                                        <td class="product_total">{{$temp = $product->ucp*$getCart->quantity}}</td>
                                        @php($total += $temp)
                                    </tr>
                                @endforeach
                                <input type="hidden" name="total" value="{{$total}}">
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </span>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{asset('assets/js/map.js')}}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqSTkzPn8PpJBY3Pclu-TTjmGDLzqKMD4&libraries=places&callback=calcDistance"
        async defer></script>
@endsection

