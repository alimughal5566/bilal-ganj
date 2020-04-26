<div class="row shop_wrapper" id="tag_container">
    @if(count($allProducts)!=0)
        @foreach($products as $product)
            {{! $images = $product->media()->get()}}
            {{! $count = count($images)}}
            {{!$amount = $product->ucp,
               $amount += $amount/100 * $product->discount}}

            <div class="col-lg-4 col-md-4 col-12 my_products">
                <div class="single_product">
                    <div class="product_name grid_name  my_product">
                        <h3>
                            <a href="{{route('productDetail',['id'=>$product->id])}}">{{$product->name}}</a>
                        </h3>
                    </div>
                    <div class="product_thumb">

                        <a class="primary_img"
                           href="{{route('productDetail',['id'=>$product->id])}}"><img
                                    src="{{asset('assets/images/'.$images[0]->image)}}"
                                    alt=""></a>

                        @if($count>1)
                            <a class="secondary_img"
                               href="{{route('productDetail',['id'=>$product->id])}}"><img
                                        src="{{asset('assets/images/'.$images[1]->image)}}"
                                        alt=""></a>
                        @endif
                        @if($product->discount)
                            <div class="label_product">
                                <span class="label_sale">-{{$product->discount}}%</span>
                            </div>
                        @endif
                        <div class="action_links">
                            <ul>
                                <input type="hidden" name="product_name" value="{{$product->name}}">
                                <input type="hidden" name="price" value="{{$product->ucp}}">
                                <input type="hidden" name="old_price" value="{{round($amount)}}">
                                <input type="hidden" name="description"
                                       value="{{$product->description}}">
                                <input type="hidden" name="condition"
                                       value="{{$product->condition}}">
                                <input type="hidden" name="id" value="{{$product->id}}">
                                <input type="hidden" name="quantity" value="{{$product->quantity}}">
                                <input type="hidden" name="images" value="{{$images[0]->image}}">
                                <input type="hidden" name="image_size" value="{{$count}}">
                                <li class="quick_button"><a href="#" data-toggle="modal"
                                                            data-target="#modal_box"
                                                            title="quick view">

                                        <span class="lnr lnr-magnifier custom_wish"></span></a></li>
                                <li class="wishlist">
                                    <a title="Add to Wishlist">
                                        @if(Auth::check())
                                            <span class="lnr lnr-heart wish custom_wish"
                                                  id="{{Auth::user()->id}}"
                                                  data-token="{{ csrf_token() }}"></span>
                                            <input type="hidden" value="{{$product->id}}">
                                        @else
                                            <span class="lnr lnr-heart custom_wish" data-toggle="modal"
                                                  data-target="#centralModalSuccess"></span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_content grid_content">
                        <div class="content_inner">
                            <div class="product_footer d-flex align-items-center">
                                <div class="price_box">
                                    <span class="current_price">PKR. {{$product->ucp}}</span>
                                    @if($product->discount)
                                        <span class="old_price">{{round($amount)}}</span>
                                    @endif
                                </div>
                                <div class="add_to_cart">
                                    <form>
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <input type="hidden" name="user_id"
                                               value="{{Auth::user()?Auth::user()->id:''}}">

                                        <a title="add to cart">
                                        <span class="{{Auth::check()?'cart_btn custom_cart':" bg-transparent border-0 goto_cart"}} lnr lnr-cart"
                                              data-toggle="{{Auth::check()?'':'modal'}}"
                                              data-target="{{Auth::check()?'':'#centralModalSuccessCart'}}">

                                        </span>
                                        </a>
                                    </form>
                                </div>
                            </div>
                            <div class="text_available">
                                @if($product->in_stock === 'Yes')
                                    <p>availabe: <span>{{$product->quantity}} in stock</span>
                                        @if($product->buy_product != null && $product->get_product != null)
                                            <span class="custom_deal rounded p-1 w-auto text-white">
                                                Deal
                                            </span>
                                        @endif
                                    </p>
                                @endif
                                @if($product->in_stock === 'No')
                                    <p><span class="text-danger">No item in stock</span></p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="product_content list_content">
                        <div class="left_caption">
                            <div class="product_name">
                                <h3><a href="{{route('productDetail')}}"><b>{{$product->name}}</b></a>
                                </h3>
                            </div>
                            <div class="product_ratings">
                                <p>Condition: {{$product->condition}}</p>
                            </div>
                            <div class="product_desc">
                                <p>{{$product->description}}</p>
                            </div>
                        </div>
                        <div class="right_caption">
                            <div class="text_available">
                                @if($product->in_stock === 'Yes')
                                    <p>availabe: <span>{{$product->quantity}} in stock</span></p>
                                @endif
                                @if($product->in_stock === 'No')
                                    <p><span class="text-danger">No item in stock</span></p>
                                @endif
                            </div>
                            <div class="price_box">
                                <span class="current_price">PKR. {{$product->ucp}}</span>
                                {{--<span class="old_price">$420.00</span>--}}
                            </div>
                            <div class="cart_links_btn">
                                <form>
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <input type="hidden" name="user_id"
                                           value="{{Auth::user()?Auth::user()->id:''}}">

                                    <button class="{{Auth::check()?'cart_btn':'goto_login'}}"
                                            type="button">
                                        <a href="#" title="add to cart">add to cart</a>
                                    </button>
                                </form>
                            </div>
                            <div class="action_links_btn">
                                <ul>
                                    <input type="hidden" name="product_name" value="{{$product->name}}">
                                    <input type="hidden" name="price" value="{{$product->ucp}}">
                                    <input type="hidden" name="old_price" value="{{round($amount)}}">
                                    <input type="hidden" name="description"
                                           value="{{$product->description}}">
                                    <input type="hidden" name="condition"
                                           value="{{$product->condition}}">
                                    <input type="hidden" name="id" value="{{$product->id}}">
                                    <input type="hidden" name="quantity" value="{{$product->quantity}}">
                                    <input type="hidden" name="images" value="{{$images[0]->image}}">
                                    <input type="hidden" name="image_size" value="{{$count}}">
                                    <li class="quick_button"><a href="#" data-toggle="modal"
                                                                data-target="#modal_box"
                                                                title="quick view">

                                            <span class="lnr lnr-magnifier"></span></a></li>
                                    <li class="wishlist"><a href="#"
                                                            title="Add to Wishlist"><span
                                                    class="lnr lnr-heart"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="mx-auto">
            <img src="{{asset('assets/frontend/img/NoRecordFound.png')}}">
        </div>
    @endif
</div>
<div class="shop_toolbar t_bottom">
    <div class="pagination">
        <ul>
            @if(!isset($flag))
                <li>{{$products->links()}}</li>
            @endif
        </ul>
    </div>
</div>

<!-- modal area start-->
<div class="modal fade" id="modal_box" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal_body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <div class="modal_tab">
                                <div class="tab-content product-details-large">
                                    <div class="tab-pane fade show active" id="tab"
                                         role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a class="modal_img" href="#">
                                                <img
                                                        src="{{asset('assets/images/')}}"
                                                        alt="product img">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal_tab_button">
                                    <ul class="nav product_navactive owl-carousel" role="tablist">
                                        <li>
                                            <a class="nav-link active" data-toggle="tab"
                                               href="#tab"
                                               role="tab"
                                               aria-controls="tab" aria-selected="false"><img
                                                        src=""
                                                        alt=""></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="modal_right">
                                <div class="modal_title mb-10">
                                    <h2></h2>
                                </div>
                                <div class="modal_price mb-10">
                                    <span class="current_price"></span>
                                    <span class="old_price"></span>
                                </div>
                                <div class="modal_description mb-15">
                                    <p></p>
                                </div>
                                <div>
                                    <strong>Condition </strong>
                                    <span class="condition"></span>
                                </div>
                                <div class="variants_selects pt-5">
                                    <div class="modal_add_to_cart">
                                        <form class="modal_cart" action="#">
                                            @csrf
                                            <input min="0" max="" value="1"
                                                   name="get_quantity" class="get_quantity"
                                                   type="number">
                                            <input type="hidden" name="product_id" value="">
                                            <input type="hidden" name="user_id"
                                                   value="{{Auth::user()?Auth::user()->id:''}}">

                                            <button class="{{Auth::check()?'cart_btn':'goto_login'}}"
                                                    type="button">
                                                add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal area end-->

