@extends('layout.frontend-layout')
@section('title','Wish List')
@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{route('index')}}">home</a></li>
                            <li>Wishlist</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->


    <!--wishlist area start -->
    <div class="wishlist_area mt-30">
        <div class="container">
            <form action="#">
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc wishlist">
                            <div class="cart_page table-responsive">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="product_remove">Delete</th>
                                        <th class="product_thumb">Image</th>
                                        <th class="product_name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product_quantity">Stock Status</th>
                                        <th class="product_total">Add To Cart</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($allWhishs as $wish)
                                        {{! $product = $wish->product()->first()}}
                                    <tr>
                                        <td class="product_remove"><a href="#" id="{{$wish->id}}"  class="delete_wish"><i onclick="return confirm('Do you want to delete Product from Wishlist')" class="fa fa-trash-o"></i></a></td>
                                        <td class="product_thumb"><a href="#"><img src="{{asset('assets/images/'.$product->media()->first()->image)}}" alt=""></a></td>
                                        <td class="product_name"><a href="#">{{$product->name}}</a></td>
                                        <td class="product-price">{{$product->ucp}}</td>
                                        <td class="product_quantity">{{$product->in_stock}}</td>
                                        <td class="cart_links_btn">
                                            <form>
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <input type="hidden" name="user_id"
                                                       value="{{Auth::user()?Auth::user()->id:''}}">

                                                <button class="{{Auth::check()?'cart_btn':'goto_login'}}" type="button">
                                                    <a class="text-white font-weight-bold" href="#" title="add to cart">add to cart</a>
                                                </button>
                                            </form>
                                        </td>
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
    <!--wishlist area end -->
    @endsection
