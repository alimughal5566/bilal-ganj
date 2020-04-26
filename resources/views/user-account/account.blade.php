@extends('layout.frontend-layout')

@section('title','My Account')

@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{route('index')}}">home</a></li>
                            <li>My account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!-- my account start  -->
    <section class="main_content_area margin_bottom">
        <div class="container">
            <div class="account_dashboard">
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <!-- Nav tabs -->
                        <div class="dashboard_tab_button">
                            <ul role="tablist" class="nav flex-column dashboard-list" id="myTab">
                                <li><a href="#account-details" data-toggle="tab" class="nav-link active">Account
                                        details</a></li>
                                <li><a href="#orders" data-toggle="tab" class="nav-link">Orders</a></li>
                                <li><a href="#address" data-toggle="tab" class="nav-link">Addresses</a></li>
                                <li><a href="{{route('logout')}}" class="nav-link">logout</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade" id="orders">
                                <h3>Orders</h3>
                                <div class="table-responsive">
                                    @if(isset($orders))
                                        <span class="text-danger">
                                            * Your Estimated Delivery time should be considered when your order status change to (on the way)
                                            within one working day
                                        </span>
                                    @endif
                                    <table class="table mt-3">
                                        <thead>
                                        <tr class="no_wrap">
                                            <th>Order ID</th>
                                            <th>Total Amount</th>
                                            <th>Delivery Date</th>
                                            <th>Estimated Delivery Time Within</th>
                                            <th>Status</th>
                                            <th>View On Map</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            @php
                                                $date = date('d-M-Y',strtotime($order->estimated_time));
                                                $time = date('h:i:s',strtotime($order->estimated_time));
                                                $ride = $order->riderLog()->first();
                                            @endphp
                                            <tr>
                                                <td>{{$order->id}}</td>
                                                <td>RS. {{$order->amount}}</td>
                                                <td>{{$date}}</td>
                                                <td>{{$time}}</td>
                                                <td><span
                                                        class="success {{$order->status === 'pending' ? 'text-primary':'text-success'}}">{{$order->status}}</span>
                                                </td>
                                                @if($order->status != 'pending')
                                                    <td><a href="{{route('viewOnMap',['order_id'=>$order->id])}}"><i
                                                                class="fa fa-globe"></i></a></td>
                                                @else
                                                    <td><a><i class="fa fa-ban"></i></a></td>
                                                @endif
                                                <td><a href="{{route('orderDetails',['id'=>$order->id])}}" class="view">Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="address">
                                <p>The following addresses will be used to deliver a Order.</p>
                                <h4 class="billing-address">Billing address</h4>
                                <p><strong>{{Auth::user()->name}}</strong></p>
                                <address>
                                    {{Auth::user()->address}}
                                </address>
                                <p>Pakistan</p>
                            </div>
                            <div class="tab-pane fade active" id="account-details">
                                <h3>Account details </h3>
                                <div class="login">
                                    <div class="login_form_container">
                                        <div class="account_login_form account_form">
                                            <form action="{{route('editProfile')}}" name="editForm"
                                                  class="needs-validation p-5" method="post" novalidate>
                                                @csrf
                                                @if($message = Session::get('success'))
                                                    <div class="alert alert-success">{{$message}}</div>
                                                @endif
                                                <div>
                                                    <label>User Name</label>
                                                    <input type="text" class="form-control mb-1" name="name"
                                                           value="{{Auth::user()->name}}" readonly>
                                                    @include('error.error',['filed'=>'name'])
                                                    <div class="invalid-feedback">
                                                        Name is Required
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Address*</label>
                                                    <textarea rows="3" id="refrence_set" value="" data-toggle="modal"
                                                              data-target="#myModal"
                                                              cols="120"
                                                              class="controls form-control size location mb-1"
                                                              placeholder="Enter location" name="address"
                                                              required>{{Auth::user()->address}}</textarea>
                                                    <input type="hidden" value="31.5204" id="lati" name="latitude">
                                                    <input type="hidden" value="74.3587" id="longi" name="longitude">
                                                    @include('error.error',['filed'=>'address'])
                                                    <div class="invalid-feedback">
                                                        Address is Required
                                                    </div>
                                                </div>
                                                <div>
                                                    <label>Contact Number*</label>
                                                    <input type="number" min="0" name="contact_number"
                                                           class="form-control mb-1"
                                                           value="{{Auth::user()->contact_number}}"
                                                           placeholder="Enter Your Contact Number" required>
                                                    @include('error.error',['filed'=>'contact_number'])
                                                    <div class="invalid-feedback">
                                                        Valid Number is Required
                                                    </div>
                                                </div>
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control"
                                                       value="{{Auth::user()->email}}"
                                                       readonly>
                                                <div class="save_button primary_btn default_button mt-4">
                                                    <a>
                                                        <button type="submit" class="ml-0">Update
                                                        </button>
                                                    </a>
                                                    <a href="{{route('changePasswordView')}}">
                                                        <button type="button" class="">Change Password
                                                        </button>
                                                    </a>
                                                </div>
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
    </section>
    <!-- my account end   -->
    @include('partial.location-modal')
@endsection
@section('scripts')
    <script src="{{asset('assets/js/map.js')}}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqSTkzPn8PpJBY3Pclu-TTjmGDLzqKMD4&libraries=places&callback=initialize"
        async defer></script>
@endsection
