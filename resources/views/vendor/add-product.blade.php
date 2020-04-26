@extends('layout.vendor-layout')

@section('title','Vendor Panel')

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/admin/css/chosen.css')}}">
@endsection

@section('content','Add Products')

@section('rightPane')
    <div class="col-sm-12 col-md-9 col-lg-9">
        <!-- Tab panes -->
        <div class="tab-pane active" id="account-details">
            <h3>Product </h3>
            <div class="login">
                {{--{{$vendor}}--}}
                <div class="login_form_container">
                    <div class="account_login_form account_form">
                        <form action="{{isset($edit)?route('editProductSave'):route('addProduct')}}" method="post" class="needs-validation shadow p-5"
                              enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="user_id" value="{{isset($vendor) ? $vendor->user_id : Auth::user()->id}}">
                            @if(isset($edit))
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                            @endif
                            @if($mes = Session::get('addProduct'))
                                <div class="alert alert-success">{{$mes}}</div>
                            @endif
                            @if($mes = Session::get('editProduct'))
                                <div class="alert alert-success">{{$mes}}</div>
                            @endif
                            @csrf
                            <h2 class="d-flex justify-content-center">{{isset($edit)?'Edit Product':'Product Detail'}}</h2>
                            <div class="form-row">
                                <div class="col-md-6 col-12">
                                    <label>{{isset($edit)?'Edit Product':'Product Name'}} <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control mb-1" name="name" value="{{isset($edit)?$product->name:old('name')}}" required>
                                    @include('error.error', ['filed' => 'name'])
                                    <div class="invalid-feedback">
                                        Product Name Required
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label>Quantity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control mb-1" min="0" name="quantity"
                                           value="{{isset($edit)?$product->quantity:old('quantity')}}" required>
                                    @include('error.error', ['filed' => 'quantity'])
                                    <div class="invalid-feedback">
                                        Quantity Required
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 col-12"><label>Descrition<span
                                                class="text-danger">*</span></label>
                                    <textarea rows="3" cols="68" class="form-control size" name="description"
                                              required>{{isset($edit)?$product->description:old('description')}}</textarea>
                                    @include('error.error', ['filed' => 'description'])
                                    <div class="invalid-feedback">
                                        Description Required
                                    </div>
                                </div>
                            </div>
                            @if(!isset($edit))
                                <div class="form-row mt-2">
                                    <div class="col-md-4 col-12">
                                        <label>Select Category <span class="text-danger">*</span></label>
                                        <div>
                                            <select name="parent_id" id="parent_id" data-placeholder="Select Catagory"
                                                    class="form-control chosen-select dynamic" data-dependent="brand"
                                                    required>
                                                <option value=""></option>

                                                @foreach($categories as $category)
                                                    @if($category->id===3 || $category->id===4)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @include('error.error', ['filed' => 'parent_id'])
                                            <div class="invalid-feedback">
                                                Category Required
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <label>Select Brand <span class="text-danger">*</span></label>
                                        <div class="brand">
                                            <select name="brand" id="brand" data-placeholder="Select Brand"
                                                    class="form-control chosen-select r_dynamic" data-dependent="release" required>
                                                <option value=""></option>

                                            </select>
                                            @include('error.error', ['filed' => 'brand'])
                                            <div class="invalid-feedback">
                                                Brand Required
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <label>Select Release <span class="text-danger">*</span></label>
                                        <div class="release">
                                            <select name="release" id="release" data-placeholder="Select Brand"
                                                    class="form-control chosen-select " required>
                                                <option value=""></option>
                                            </select>
                                            @include('error.error', ['filed' => 'release'])
                                            <div class="invalid-feedback">
                                                Release Required
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-row mt-2">
                                @if(!isset($edit))
                                    <div class="col-md-6 col-12">
                                        <label>Choose your image <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control w-auto mb-1" name="image[]" multiple
                                               required>
                                        @include('error.error', ['filed' => 'image'])
                                        <div class="invalid-feedback">
                                            Image Required
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6 col-12">
                                    <label>Size <span class="text-danger">*</span></label>
                                    <div>
                                        <select id="size" name="size"
                                                class="form-control col-md-6 col-12 chosen-select"
                                                value="{{old('size')}}" required>
                                            <option value="">-Select Size-</option>
                                            <option value="Small">Small</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Large">Large</option>
                                        </select>
                                        @include('error.error',['filed'=>'size'])
                                        <div class="invalid-feedback">
                                            Product size required
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-row mt-2">
                                <div class="col-md-6 col-12">
                                    <label>Price (PKR) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control mb-1" min="0" name="ucp"
                                           value="{{isset($edit)?$product->ucp:old('ucp')}}"
                                           required>
                                    @include('error.error', ['filed' => 'ucp'])
                                    <div class="invalid-feedback">
                                        Price Required
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label>Discount (%)</label>
                                    <input type="number" class="form-control mb-1" min="0" name="discount"
                                           value="{{isset($edit)?$product->discount:old('discount')}}" placeholder="0-100" required>
                                    @include('error.error', ['filed' => 'discount'])
                                    <div class="invalid-feedback">
                                        Discount Required
                                    </div>
                                </div>
                            </div>
                            @if(!isset($edit))
                                <div class="form-row mt-2">
                                    <div class="col-md-6 col-12">
                                        <label>Condition <span class="text-danger">*</span></label>
                                        <div>
                                            <select id="year" name="condition"
                                                    class="form-control col-md-6 col-12 chosen-select"
                                                    value="{{old('condition')}}" required>
                                                <option value="">-Select Condition-</option>
                                                <option value="New">New</option>
                                                <option value="Used">Used</option>
                                            </select>
                                            @include('error.error', ['filed' => 'condition'])
                                            <div class="invalid-feedback">
                                                Condition Required
                                            </div>
                                        </div>
                                    </div>
                                    {{ !$years = now()->year }}
                                    <div class="col-md-6 col-12">
                                        <label>Model <span class="text-danger">*</span></label>
                                        <div>
                                            <select id="year" name="model"
                                                    class="form-control col-md-6 col-12 chosen-select"
                                                    value="{{old('model')}}" required>

                                                <option value="">-Select Model-</option>
                                                @for($i=$years; $i>$years-100; $i--)

                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                            @include('error.error',['filed'=>'model'])
                                            <div class="invalid-feedback">
                                                Model required
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-row m-2">
                                    <div class="col-md-12 col-12 mt-2">
                                        You want to give Deal?

                                        <div class="form-check">
                                            <input type="radio" name="deal" class="form-check-input rad" id="nodeal" checked>
                                            <label class="form-check-label" for="nodeal">No</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="deal" class="form-check-input rad" id="deal">
                                            <label class="form-check-label" for="deal">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="form-row mt-2" id="project">
                                    <div class="col-md-6 col-12">
                                        <label>Buy Product <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control mb-1" min="1" name="buy_product"
                                               value="{{isset($edit)?$product->buy_product:old('buy_product')}}"
                                               >
                                        @include('error.error', ['filed' => 'buy_product'])
                                        <div class="invalid-feedback">
                                            Buy Product Required
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label>Get Product <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control mb-1" min="1" name="get_product"
                                               value="{{isset($edit)?$product->get_product:old('get_product')}}">
                                        @include('error.error', ['filed' => 'get_product'])
                                        <div class="invalid-feedback">
                                            Get Product Required
                                        </div>
                                    </div>
                                </div>
                            <div class="form-row pt-3 d-flex justify-content-end">
                                <div class="login_submit align-content-start">
                                    <button type="submit" class="btn btn-block btn-success ml-0">Save</button>

                                </div>
                            </div>
                        </form>

                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{asset('assets/admin/js/chosen.jquery.js')}}"></script>
    <script src="{{asset('assets/admin/js/init.js')}}"></script>
@endsection