@extends('layout.vendor-layout')

@section('title','Vendor Panel')

@section('content','Account Details')

@section('rightPane')

    <div class="col-sm-12 col-md-9 col-lg-9">
        <!-- Tab panes -->
        <div class="tab-content dashboard_content">
            <div class="tab-pane fade" id="orders">
                <h3>Orders</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>May 10, 2018</td>
                            <td><span class="success">Completed</span></td>
                            <td>$25.00 for 1 item</td>
                            <td><a href="cart.html" class="view">view</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>May 10, 2018</td>
                            <td>Processing</td>
                            <td>$17.00 for 1 item</td>
                            <td><a href="cart.html" class="view">view</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{--                {{dd(($vendor))}}--}}
            <div class="tab-pane" id="address">
                <p>The following addresses will be used to deliver a Order.</p>
                <h4 class="billing-address">Billing address</h4>
                <p><strong>{{isset($vendor)? $vendor->user()->first()->name : Auth::user()->name}}</strong></p>
                <address>
                    {{isset($vendor)? $vendor->user()->first()->address : Auth::user()->address}}
                </address>
                <p>Pakistan</p>
            </div>
            <div class="tab-pane fade active" id="account-details">
                <div class="login">
                    <div class="login_form_container">
                        <div class="account_login_form account_form">

                            <div class="tab-pane  active" id="account-details">
                                <h3>Account details </h3>
                                <div class="login">
                                    <div class="login_form_container">
                                        <div class="account_login_form account_form">
                                            <form action="{{route('editVendorProfile')}}" name="editForm"
                                                  class="needs-validation p-5" method="post" novalidate>
                                                @csrf
                                                @if($message = Session::get('success'))
                                                    <div class="alert alert-success">{{$message}}</div>
                                                @endif

                                                <input type="hidden" name="user_id"
                                                       value="{{isset($vendor)? $vendor->user_id  : Auth::user()->id}}">
                                                <div>
                                                    <label>User Name</label>
                                                    <input type="text" class="form-control mb-1" name="name"
                                                           value="{{isset($vendor)? $vendor->user()->first()->name  : Auth::user()->name}}"
                                                           readonly>
                                                </div>
                                                <div>
                                                    <label>Shop Name*</label>
                                                    <input type="text" class="form-control mb-1" name="shop_name"
                                                           value="{{isset($vendor)? $vendor->shop_name : Auth::user()->bgShop()->first()->shop_name}}"
                                                           required>
                                                    @include('error.error',['filed'=>'shop_name'])
                                                    <div class="invalid-feedback">
                                                        Shop Name is Required
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Address</label>
                                                    <input type="text" name="address" class="form-control"
                                                           value="{{isset($vendor)? $vendor->user()->first()->address : Auth::user()->address}}"
                                                           readonly>
                                                </div>
                                                <div>
                                                    <label>Contact Number*</label>
                                                    <input type="number" min="0" name="contact_number"
                                                           class="form-control mb-1"
                                                           value="{{isset($vendor) ? $vendor->user()->first()->contact_number : Auth::user()->contact_number}}"
                                                           required>
                                                    @include('error.error',['filed'=>'contact_number'])
                                                    <div class="invalid-feedback">
                                                        Valid Number is Required
                                                    </div>
                                                </div>

                                                <div>
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                           value="{{isset($vendor) ? $vendor->user()->first()->email : Auth::user()->email}}"
                                                           readonly>
                                                </div>
                                                @if(Auth::user()->type === 'bgshop')
                                                    <div class="save_button primary_btn default_button mt-4">
                                                        <a>
                                                            <button type="submit" class="ml-0">Save
                                                            </button>
                                                        </a>
                                                        <a href="{{route('vendorPassword', isset($vendor)? $vendor->user_id : null)}}">
                                                            <button type="button" class="">Change Password
                                                            </button>
                                                        </a>
                                                    </div>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

