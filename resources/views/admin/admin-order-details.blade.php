@extends('layout.backend-layout')

@section('title','Admin-Panel')

@section('content')
    <div id="content-wrapper">

        <div class="container-fluid">
            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card-header">
                    <a href="{{route('orderList')}}" class="text-dark"><i class="fas fa-table"></i></a>
                    Back to Order List
                </div>
                <div class="card-body">
                    <div id="no-more-tables">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
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
                                            <span>RS. {{$product->ucp}}</span>
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
                @if(isset($time))
                    <div class="card-footer small text-muted">Last Entry
                        at {{$time->updated_at->format('d M, Y h:i A')}}</div>
                @endif
            </div>

        </div>
    </div>
@endsection