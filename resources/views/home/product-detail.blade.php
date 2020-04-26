@extends('layout.frontend-layout')
@section('title','Product Detail')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/jssocials.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/jssocials-theme-flat.css')}}">
@endsection
@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            @if(Auth::check() && Auth::user()->type==='user')
                                <li><a href="{{route('shop')}}">shop</a></li>
                            @endif
                            <li>product details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->
    {{!$images =  $product->media()->get()}}

    <!--product details start-->
    <div class="product_details mt-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-tab">

                        <div id="img-1" class="zoomWrapper single-zoom">
                            <a href="#">
                                <img id="zoom1" src="{{asset('assets/images/'.$images[0]->image)}}"
                                     data-zoom-image="{{asset('assets/images/'.$images[0]->image)}}" alt="big-1">
                            </a>
                        </div>

                        <div class="single-zoom-thumb">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                @foreach($images as $image)
                                    <li>
                                        <a href="#" class="elevatezoom-gallery active" data-update=""
                                           data-image="{{asset('assets/images/'.$image->image)}}"
                                           data-zoom-image="{{asset('assets/images/'.$image->image)}}">
                                            <img src="{{asset('assets/images/'.$image->image)}}"
                                                 alt="zo-th-1"/>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right">
                        <form action="#">

                            <h1>{{$product->name}}</h1>
                            <div class="product_nav">
                                @if(Auth::check() && Auth::user()->type==='bgshop')
                                @else
                                    <ul>
                                        <li class="prev"><a href="{{$previous}}"><i class="fa fa-angle-left"></i></a>
                                        </li>
                                        <li class="next"><a href="{{$next}}"><i class="fa fa-angle-right"></i></a></li>
                                    </ul>
                                @endif
                            </div>
                            <div class="price_box">
                                <span class="current_price">PKR. {{$product->ucp}}</span>
                                @if($product->discount)
                                    <span class="old_price">{{round($amount)}}</span>
                                @endif
                            </div>
                            <div class="product_desc pb-1">
                                <p>{{$product->description}} </p>
                                @if($product->buy_product != null && $product->get_product != null)
                                    <div class="text-secondary my-1">
                                        <strong>Deal: </strong><span> By {{$product->buy_product}} products get {{$product->get_product}} free</span>
                                    </div>
                                @endif
                            </div>
                            <div class="text_available">
                                @if($product->in_stock === 'Yes')
                                    <p>availabe: <span>{{$product->quantity}} in stock</span></p>
                                @endif
                                @if($product->in_stock === 'No')
                                    <p><span class="text-danger">No item in stock</span></p>
                                @endif
                            </div>
                            @if(Auth::check() && Auth::user()->type==='bgshop')
                            @else
                                <div class="product_variant quantity">
                                    <label>quantity</label>
                                    @csrf
                                    <input min="0" max="{{$product->quantity}}" value="{{1}}" name="get_quantity"
                                           class="get_quantity" type="number">
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <input type="hidden" name="user_id"
                                           value="{{Auth::user()?Auth::user()->id:''}}">
                                    <button class="button {{Auth::check()?'cart_btn':'goto_login'}}"
                                            type="button">
                                        add to cart
                                    </button>
                                </div>

                                <div class=" product_d_action">
                                    <ul>
                                        <li><a href="#" title="Add to wishlist">+ Place Order</a></li>
                                        <li><a href="#" title="Add to wishlist">+ Add to Wishlist</a></li>
                                    </ul>
                                </div>
                            @endif

                            <h1 class="mt-5">Share Product On:</h1>
                            <span class="share_product">
                                <div id="shareRoundIcons"></div>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product details end-->

    <!--product info start-->
    <div class="product_d_info">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_d_inner">
                        <div class="product_info_button">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info"
                                       aria-selected="false">Description</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet"
                                       aria-selected="false">Specification</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews"
                                       aria-selected="false">Comments</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="info" role="tabpanel">
                                <div class="product_info_content">
                                    <p>{{$product->description}}</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sheet" role="tabpanel">
                                <div class="product_d_table">
                                    <form action="#">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td class="first_child">Available</td>
                                                <td>{{$product->in_stock}}</td>
                                            </tr>
                                            <tr>
                                                <td class="first_child">Condtion</td>
                                                <td>{{$product->condition}}</td>
                                            </tr>
                                            <tr>
                                                <td class="first_child">Vehicle</td>
                                                <td>{{$product->categories()->first()->name}}</td>
                                            </tr>
                                            @if($product->discount)
                                                <tr>
                                                    <td class="first_child">You Saved Money</td>
                                                    <td>PKR. {{round($amount-$product->ucp)}}</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <div class="product_info_content">
                                    <p>{{$product->description}}</p>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="reviews" role="tabpanel" class="review_comment">

                                <div class="reviews_wrapper ">
                                    <div class="reviews_comment_box">
                                        <div class="comment_text">

                                            @foreach($comment as $feedback)
                                                <div class="reviews_meta">
                                                    <p class="mb-1">
                                                        <input type="hidden" class="feedback_id" name="feedback_id"
                                                               value="{{$feedback->id}}">
                                                        <input type="hidden" class="feedback_message"
                                                               name="feedback_message" value="{{$feedback->message}}">
                                                        @if(Auth::check() && Auth::user()->id == $feedback->user()->first()->id)
                                                            <span class="float-right" class="comment" role="group">
                                                            <button id="comment_btn" type="button"
                                                                    class="btn dropdown-toggle" data-toggle="dropdown"
                                                                    aria-haspopup="true">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </button>
                                                            <span class="dropdown-menu" aria-labelledby="comment_btn">
                                                                <button type="submit" class=" btn edit"
                                                                        name="edit" id="edit" data-toggle="modal"
                                                                        data-target="#myModal"><a
                                                                            href="#">Edit</a></button><br>
                                                                <button type="submit" class="btn delete_btn"
                                                                        name="remove" id="remove"><a
                                                                            href="{{route('removeFeedback',['id'=>$feedback->id])}}"
                                                                            onclick="return confirm('Are you sure you want to delete this feedback')"
                                                                            class="delete_comment">Delete</a></button>
                                                            </span>
                                                        </span>
                                                        @endif
                                                        <span>{{$feedback->user()->first()->name}}</span><label
                                                                class="ml-4">

                                                            <small> {{$feedback->created_at}}</small>
                                                        </label>
                                                    </p>
                                                    <span>{{$feedback->message}}</span>
                                                </div>
                                                <hr>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="comment_title">
                                        <h2>Add Comment </h2>
                                    </div>

                                    <div class="product_review_form">
                                        <form action="{{route('addFeedback')}}" method="post" id="comment_form">
                                            @csrf
                                            <div class="form-row">
                                                <div class="col-12">
                                                    <input type="hidden" name="user_name" id="user_name"
                                                           value="{{Auth::user()?Auth::user()->name:''}}"
                                                           class="form-control">
                                                    <input type="hidden" name="user_id" id="user_id"
                                                           value="{{Auth::user()?Auth::user()->id:''}}"
                                                           class="form-control">
                                                    <input type="hidden" name="product_id" id="product_id"
                                                           value="{{$product->id}}" class="form-control">
                                                    <textarea name="message" class="form-control p-4"
                                                              placeholder="Enter Comment" id="message"
                                                              required></textarea>
                                                    @include('error.error', ['filed' => 'message'])
                                                    <div class="invalid-feedback">
                                                        Comment Required
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="submit" id="submit">Submit</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                @include('home.include.home-products')
            </div>
        </div>
    </div>
    <!--product info end-->


    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Comment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form action="{{route('updateFeedback')}}" method="post" id="comment_form" class="p-2">

                    @csrf
                    <div class="form-row">
                        <div class="col-12">
                            <input type="hidden" name="comment_id" id="comment_id"
                                   class="form-control my_id">
                            <textarea name="message" class="form-control my_message"
                                      placeholder="Enter Comment" id="message"
                                      required></textarea>
                            @include('error.error', ['filed' => 'message'])
                            <div class="invalid-feedback">
                                Comment Required
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary" name="submit" id="submit">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('assets/js/jssocials.js')}}"></script>
    <script>
        $("#shareRoundIcons").jsSocials({
            showLabel: false,
            showCount: false,
            shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest"]
        });
    </script>
@endsection
