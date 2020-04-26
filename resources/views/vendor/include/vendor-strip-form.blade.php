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
                                    <div class="alert alert-success">
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

                                <form role="form"  method="post" action="{{route('getCredit',['id'=>$vendor->user_id])}}"
                                      class="border_grey p-4 account_form needs-validation require-validation"
                                      novalidate
                                      data-cc-on-file="false"
                                      data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                      id="payment-form">
                                    @csrf
                                    <input type="hidden" name="vendor_id" value="{{$vendor->id}}"/>
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
                                    <div class="form-row row">
                                          <div class="col form-group card required p-2">
                                            <label class="control-label"> Number of credits points</label>
                                            <input type="number" name="total_credits" class="form-control card-number" id="credits" value="{{old('total_credits')}}"/>
                                        </div>
                                    </div>
                                    <div class='form-row row'>
                                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                                            <label class='control-label'>CVC</label>
                                            <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311'
                                                   name="cvc" maxlength="3" type='text' value="{{old('cvc')}}" onkeypress="return /[0-9]/i.test(event.key)" required />
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
                                        <input type="hidden" name="amount" />
                                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <button class="btn btn-primary btn-lg btn-block stripe_payment" type="submit">Pay Now (RS.<i id="total_price"></i>)</button>
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