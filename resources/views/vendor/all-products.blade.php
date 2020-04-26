@extends('layout.vendor-layout')

@section('title','Vendor Panel')

@section('content','All Products')

@section('rightPane')
    <div class="col-sm-12 col-md-10 col-lg-9">
        <!--wishlist area start -->
        <div class="wishlist_area mt-30">
            <div class="container">
                <form action="#">
                    <div class="row p-1">
                        <div class="col-12">
                            <div class="table_desc wishlist">
                                <div class="cart_page table-responsive">
                                    @if($message = Session::get('success'))
                                        <div class="alert alert-success mb-3">
                                            {{$message}}
                                        </div>
                                    @endif
                                    <table>
                                        <thead>
                                        <tr>
                                            <th class="product_remove">Name</th>
                                            <th class="product_thumb">Image</th>
                                            <th class="product_thumb">Quantity</th>
                                            <th class="product_name">Condition</th>
                                            <th class="product-price">Price</th>
                                            <th class="product_quantity">Discount</th>
                                            <th class="product_total">Model</th>
                                            <th class="product_total">Is Feature</th>
                                            @if(Auth::user()->type==='agent')
                                                <th class="product_total">Edit</th>
                                                <th class="product_total">Delete</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($collect as $product)
                                            <tr>
                                                <td class="product_remove">{{$product->name}}</td>
                                                <td class="product_remove">
                                                    <a href="{{route('productDetail',['id'=>$product->id])}}"><img src="{{asset('assets/images/'.$product->media()->first()->image)}}"></a>
                                                </td>
                                                <td class="product_thumb">{{$product->quantity}}</td>
                                                <td class="product_name">{{$product->condition}}</td>
                                                <td class="product-price">{{$product->ucp}}</td>
                                                <td class="product_quantity">{{$product->discount}}</td>
                                                <td class="product_total">{{$product->model}}</td>
                                                <td class="product_total">{{$product->is_feature}}</td>
                                                @if(Auth::user()->type==='agent')
                                                    <td class="product_total"><a
                                                                href="{{route('editProduct',['id'=>$product->id , 'user_id'=>$vendor->user_id])}}"><i
                                                                    class="fas fa-edit"></i></a></td>
                                                    <td class="product_total"><a
                                                                href="{{route('deleteProduct',['id'=>$product->id])}}"
                                                                onclick="return confirm('Are you sure you want to delete this product')"><i
                                                                    class="fas fa-trash"></i></a></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection