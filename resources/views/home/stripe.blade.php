@extends('layout.frontend-layout')
@section('title','Stripe')
@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{route('index')}}">home</a></li>
                            <li><a href="{{route('cart')}}">Shopping Cart</a></li>
                            <li>Payment</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->
    <span class="main_body">
        <div class="shopping_cart_area">
            <div class="container margin_bottom">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="panel panel-default credit-card-box">
                            <div class="panel-heading display-table mb-3">
                                <div class="row display-tr">
                                    <h3 class="panel-title display-td">Payment Details</h3>
                                    <div class="display-td">
                                        <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                    </div>
                                </div>
                             </div>
                            <div class="panel-body">

                                @if (Session::has('success'))
                                    <div class="alert alert-danger">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                        <p>{{ Session::get('success') }}</p>
                                    </div>
                                @endif
                                <span class="message">
                                    <div class="alert alert-danger d-none">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                            <p>Your Card Number OR Dates are Invalid Please Correct them!</p>
                                    </div>
                                </span>
                                <form role="form" action="{{ route('stripePost') }}" method="post"
                                      class="border_grey p-4 account_form needs-validation require-validation"
                                      novalidate
                                      data-cc-on-file="false"
                                      data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                      id="payment-form">
                                    @csrf

                                    <div class='form-row row'>
                                        <div class='col form-group required'>
                                            <label class='control-label'>Name on Card</label> <input
                                                    class='form-control' value="{{old('cardName')}}"  name="cardName" size='4' type='text' required>
                                            @include('error.error', ['filed' => 'cardName'])
                                            <div class="invalid-feedback">
                                                Name of Card is Required
                                            </div>
                                        </div>
                                    </div>

                                    <div class='form-row row'>
                                        <div class='col form-group card required p-2'>
                                            <label class='control-label'>Card Number</label> <input
                                                    autocomplete='off' name="cardNumber" class='form-control card-number'
                                                    maxlength="16"
                                                    type='text' value="{{old('cardNumber')}}" onkeypress="return /[0-9]/i.test(event.key)" required>
                                            @include('error.error', ['filed' => 'cardNumber'])
                                            <div class="invalid-feedback">
                                                Card Number is Required
                                            </div>
                                        </div>
                                    </div>

                                    <div class='form-row row'>
                                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                                            <label class='control-label'>CVC</label> <input autocomplete='off'
                                                                                            class='form-control card-cvc'
                                                                                            placeholder='ex. 311'
                                                                                            name="cvc" maxlength="3"
                                                                                            type='text' value="{{old('cvc')}}" onkeypress="return /[0-9]/i.test(event.key)" required>
                                            @include('error.error', ['filed' => 'cvc'])
                                            <div class="invalid-feedback">
                                                CVC Required
                                            </div>
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label class='control-label'>Expiration Month</label> <input
                                                    class='form-control card-expiry-month' placeholder='MM' maxlength="2"
                                                    type='text' value="{{old('expMonth')}}" onkeypress="return /[0-9]/i.test(event.key)" name="expMonth" required>
                                            @include('error.error', ['filed' => 'expMonth'])
                                            <div class="invalid-feedback">
                                               Required
                                            </div>
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                            <label class='control-label'>Expiration Year</label> <input
                                                    class='form-control card-expiry-year' placeholder='YYYY' maxlength="4"
                                                    type='text' value="{{old('expYear')}}" onkeypress="return /[0-9]/i.test(event.key)" name="expYear" required>
                                            @include('error.error', ['filed' => 'expYear'])
                                            <div class="invalid-feedback">
                                                Required
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="total" value="{{$total}}">
                                    <input type="hidden" name="latitude" id="latitude" value="{{Auth::user()->latitude}}">
                                    <input type="hidden" name="longitude" id="longitude" value="{{Auth::user()->longitude}}">
                                    <input type="hidden" name="vendorLati" id="vendorLati" value="31.5803">
                                    <input type="hidden" name="vendorLongi" id="vendorLongi" value="74.3012">
                                    <input type="hidden" name="estimated_time" class="distance_field" value="">

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <button class="btn btn-primary btn-lg btn-block stripe_payment" type="submit">Pay Now (RS. {{$total}})</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </span>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{asset('assets/js/map.js')}}"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript" src="{{asset('assets/js/stripe.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqSTkzPn8PpJBY3Pclu-TTjmGDLzqKMD4&libraries=places&callback=calcDistance"
            async defer></script>
@endsection

