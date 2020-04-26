@extends('layout.vendor-layout')

@section('title','Stripe')

@section('rightPane')
    <div class="col-sm-12 col-md-12 col-lg-12">
       <div class="breadcrumbs_area">
           <div class="container">
               <div class="row">
                   <div class="col-12">
                       <div class="breadcrumb_content">
                           <ul>
                               <li><a href="{{route('vendorPanel',['id'=> Auth::user()->id])}}">home</a></li>
                               <li><a href="{{route('creditsView',['id'=> Auth::user()->id])}}">credits history</a></li>
                               <li>Payment</li>
                           </ul>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       @include('vendor.include.vendor-strip-form')
   </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript" src="{{asset('assets/js/stripe.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#leftPane').remove();

            $('#credits').change(function () {
                var given_credits = this.value;
                var total = null;
                total = given_credits * 10 ;
                $('#total_price').html(" ");
                $('#total_price').append(total);
                $('[name="amount"]').val(total);
                console.log(total);
            });
        });
    </script>

@endsection