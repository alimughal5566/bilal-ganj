<!--shopping cart area start -->
{{!$check = false}}
<div class="shopping_cart_area mt-32 mb-5">
    <div class="container">
        @if($message = Session::get('alert'))
            <div class="alert alert-danger">
                {{$message}}
            </div>
        @endif
        @if($message = Session::get('checkout'))
            <div class="alert alert-success">
                {{$message}}<a href="{{route('userAccount')}}"> <b>Order History</b></a>
            </div>
        @endif
        <form action="#">
            <div class="row">
                <div class="col-12 col-lg-8 col-md-6">
                    <div class="table_desc">
                        <div class="cart_page">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th class="product_remove">Delete</th>
                                    <th class="product_thumb">Image</th>
                                    <th class="product_name">Product Name</th>
                                    <th class="product-price">Price</th>
                                    <th class="product_quantity">Quantity</th>
                                    <th class="product_total">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($products))
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach($products as $product)
                                        @php
                                            $cart = $product->carts()->where('user_id',Auth::user()->id)->where('is_placed',0)->first();
                                            $media = $product->media()->first();
                                            $getCart = $cart->products()->wherePivot('product_id', $product->id)->first()->pivot;
                                            $amount = $product->ucp;
                                            $amount += $amount/100 * $product->discount;
                                        @endphp
                                        <tr>
                                            <input type="hidden" name="product_id"
                                                   value="{{$product->id}}">
                                            <td class="product_remove"><a href="#" class="delete_cart"><i
                                                            class="fa fa-trash-o"></i></a></td>
                                            <td class="product_thumb image_size2">
                                                <a href="{{route('productDetail',['id'=>$product->id])}}"><img
                                                            ho class="image_size2" src="{{asset('assets/images/'.$media->image)}}"
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
                                                <input type="hidden" name="product_id"
                                                       value="{{$product->id}}">
                                                <input type="hidden" name="item_quantity"
                                                       value="{{$getCart->quantity}}">
                                                <input type="number" min="1"
                                                       max="{{$product->quantity}}"
                                                       value="{{$getCart->quantity}}" class="item_qty border_grey">
                                                @if($getCart->quantity > $product->quantity)
                                                    @php($check = true)
                                                    <div class="text-danger">
                                                        Exceeding Limit
                                                        <br>
                                                        {{$product->quantity}} items in stock
                                                    </div>
                                                @endif
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
                <div class="col-12 col-lg-4 col-md-6">
                    <div class="coupon_code right">
                        <div class="coupon_inner">
                            <div class="mb-2">
                                <b><p class="mb-1">Location</p></b>
                                <i class="fas fa-map-marker-alt"></i>
                                @if(Auth::user()->address)
                                    <span class="pl-2">{{Auth::user()->address}}</span>
                                    <a class="float-right" href="{{route('userAccount')}}">Change</a>
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
                                <p>Subtotal ({{isset($count)?$count:0}} Items)</p>
                                <p class="cart_amount">RS. <span
                                            class="amount mr-0 sub_total">{{isset($total)?$total:'0'}}</span></p>
                            </div>
                            @if($products!=null)
                                <div class="cart_subtotal shipping">
                                    <p>Shipping Fee</p>
                                    <p class="cart_amount float-right">RS. <span
                                                class="mr-0 total_shipping">35</span></p>
                                </div>
                            @endif
                            <div class="border-bottom"></div>
                            <div class="cart_subtotal my-2">
                                <p>Total</p>
                                <p class="cart_amount float-right">RS. <span
                                            class="mr-0 total_amount">{{isset($total)?$orderAmount = $total+35:'0'}}</span>
                                </p>
                            </div>
                            <div class="checkout_btn">

                                @if(isset($total) && Auth::user()->address != null && $check===false)
                                    <a href="{{route('doOrder',['total'=>$total,'orderAmount'=>$orderAmount])}}">Place
                                        Order</a>
                                @elseif(Auth::user()->address === null)
                                    <a onclick="return swal('Please set billing address');">Place Order</a>
                                @elseif($check === true)
                                    <a onclick="return swal('Alert!','You are Exceeding limit of Product Quantity!','warning');">Place Order</a>
                                @else
                                    <a onclick="return swal('Please add item(s)');">Place Order</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
