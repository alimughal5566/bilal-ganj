@extends('layout.frontend-layout')

@section('title','Change Password')

@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{route('index')}}">home</a></li>
                            <li><a href="{{route('userAccount')}}">my account</a></li>
                            <li>Order Details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!-- my account start  -->
    <section class="main_content_area">
        <div class="container">
            <div class="account_dashboard">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade active" id="orders">
                                <h3>Orders</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
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
            </div>
        </div>
    </section>
    {{--<!-- my account end   -->--}}
@endsection
