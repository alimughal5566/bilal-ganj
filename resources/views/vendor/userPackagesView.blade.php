@extends('layout.frontend-layout')
@section('title','Adds packages')
@section('content')
    <div class="demo m-5">
        <div class="container">
            <div class="row">
                @if($packages)
                <div class="col-md-4 col-sm-6">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <h3 class="title">{{($packages[0]->type)}}</h3>
                            <div class="price-value">
                                <span class="currency">$</span>
                                <span class="amount">10</span>
                                <span class="amount-sm">.00/mo</span>
                            </div>
                        </div>
                        <div class="pricing-icon">
                            <i class="fa fa-bicycle"></i>
                        </div>
                        <ul class="pricing-content">
                            <li><i>Time Limit</i> {{($packages[0]->min_time)}} days</li>
                            <li>Price of Banner ${{($packages[0]->banner_price)}}</li>
                            <li>Price of Slot1 ${{($packages[0]->slot1_price)}}</li>
                            <li>Price of Slot2 ${{($packages[0]->slot2_price)}}</li>
                            <li></li>
                        </ul>
                        <a href="{{route('postAds',['id'=>$vendor->user_id , 'package_id'=>$packages[0]->id])}}" class="pricingTable-signup">Choose Basic</a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="pricingTable blue">
                        <div class="pricingTable-header">
                            <h3 class="title">Premium</h3>
                            <div class="price-value">
                                <span class="currency">$</span>
                                <span class="amount">20</span>
                                <span class="amount-sm">.00/mo</span>
                            </div>
                        </div>
                        <div class="pricing-icon">
                            <i class="fa fa-train"></i>
                        </div>
                        <ul class="pricing-content">
                            <li><i>Time Limit</i> {{($packages[1]->min_time)}} days</li>
                            <li>Price of Banner ${{($packages[1]->banner_price)}}</li>
                            <li>Price of Slot1 ${{($packages[1]->slot1_price)}}</li>
                            <li>Price of Slot2 ${{($packages[1]->slot2_price)}}</li>                            <li></li>
                        </ul>
                        <a href="{{route('postAds',['id'=>$vendor->user_id , 'package_id'=>$packages[1]->id])}}" class="pricingTable-signup">Choose Premium</a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="pricingTable red">
                        <div class="pricingTable-header">
                            <h3 class="title">Gold</h3>
                            <div class="price-value">
                                <span class="currency">$</span>
                                <span class="amount">30</span>
                                <span class="amount-sm">.00/mo</span>
                            </div>
                        </div>
                        <div class="pricing-icon">
                            <i class="fa fa-rocket"></i>
                        </div>
                        <ul class="pricing-content">
                            <li><i>Time Limit</i> {{($packages[2]->min_time)}} days</li>
                            <li>Price of Banner ${{($packages[2]->banner_price)}}</li>
                            <li>Price of Slot1 ${{($packages[2]->slot1_price)}}</li>
                            <li>Price of Slot2 ${{($packages[2]->slot2_price)}}</li>
                        </ul>
                        <a href="{{route('postAds',['id'=>$vendor->user_id , 'package_id'=>$packages[2]->id])}}" class="pricingTable-signup">Choose Gold</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
@section('styles')
    <style>
    :root{
    --white: #fff;
    --black: #000;
    }
    .pricingTable{
    background-color: #f2f2f2;
    font-family: 'Krub', sans-serif;
    text-align: center;
    padding: 0 30px 10px;
    margin: 0 30px;
    border-radius: 5px 5px 200px 200px;
    border: 1px solid rgba(0,0,0,0.03);
    position: relative;
    z-index: 1;
    transition: all 0.3s;
    }
    .pricingTable:hover{ box-shadow: 0 0 15px rgba(0,0,0,0.2); }
    .pricingTable:before,
    .pricingTable:after{
    content: '';
    background: linear-gradient(-45deg, #2a9926 49%, transparent 50%);
    width: 14px;
    height: 14px;
    position: absolute;
    left: 16px;
    top: -15px;
    z-index: -1;
    }
    .pricingTable:after{
    background: linear-gradient(45deg, #2a9926 49%, transparent 50%) ;
    left: auto;
    right: 16px;
    }
    .pricingTable .pricingTable-header{
    color: var(--white);
    background: linear-gradient(135deg,#53BD50 25%,#68c950 26%,#68c950 40%,
    #53BD50 41%,#53BD50 47%,#68c950 48%, #68c950 60%, #53BD50 61%);
    padding: 15px 0 50px;
    margin: -15px 0 0;
    -webkit-clip-path: polygon(100% 0, 100% 100%, 50% 80%, 0 100%, 0 0);
    clip-path: polygon(100% 0, 100% 100%, 50% 80%, 0 100%, 0 0);
    transition: all 0.3s;
    }
    .pricingTable:hover .pricingTable-header{ text-shadow: 0 0 2px var(--black); }
    .pricingTable .title{
    font-size: 30px;
    text-transform: uppercase;
    margin: 0 0 5px;
    }
    .pricingTable .currency{
    display: inline-block;
    font-size: 30px;
    vertical-align: top;
    }
    .pricingTable .amount{
    display: inline-block;
    font-size: 45px;
    font-weight: 600;
    line-height: 40px;
    }
    .pricingTable .amount-sm{
    display: inline-block;
    font-size: 25px;
    margin-left: -3px;
    }
    .pricingTable .pricing-icon{
    color: #606060;
    font-size: 55px;
    line-height: 60px;
    transition: all 0.3s;
    }
    .pricingTable:hover .pricing-icon{ transform: rotateY(360deg) rotate(360deg); }
    .pricingTable .pricing-content{
    padding: 0;
    margin:0 0 20px;
    list-style: none;
    display: inline-block;
    }
    .pricingTable .pricing-content li{
    color: #505050;
    font-size: 17px;
    font-weight: 600;
    line-height: 38px;
    text-transform: capitalize;
    letter-spacing: 1px;
    border-bottom: 2px solid #d1d1d1;
    }
    .pricingTable .pricingTable-signup{
    color: var(--white);
    background: linear-gradient(135deg,#53BD50 25%,#68c950 26%,#68c950 40%,
    #53BD50 41%,#53BD50 47%,#68c950 48%, #68c950 60%, #53BD50 61%);
    font-size: 15px;
    font-weight: 600;
    letter-spacing: 1px;
    text-align: center;
    text-transform: uppercase;
    line-height: 95px;
    height: 100px;
    width: 100px;
    margin: 0 auto;
    border-radius: 50%;
    border: 3px solid var(--white);
    display: block;
    transition: all 0.3s;
    }
    .pricingTable .pricingTable-signup:hover{
    box-shadow: 0 0 10px var(--black);
    text-shadow: 0 0 5px var(--black);
    }
    .pricingTable.blue:before{
    background: linear-gradient(-45deg, #097da0 49%, transparent 50%) ;
    }
    .pricingTable.blue:after{
    background: linear-gradient(45deg, #097da0 49%, transparent 50%) ;
    }
    .pricingTable.blue .pricingTable-header,
    .pricingTable.blue .pricingTable-signup{
    background: linear-gradient(135deg,#00A7E8 25%,#28baef 26%,#28baef 40%,
    #00A7E8 41%,#00A7E8 47%,#28baef 48%, #28baef 60%, #00A7E8 61%);
    }
    .pricingTable.red:before{
    background: linear-gradient(-45deg, #b53117 49%, transparent 50%) ;
    }
    .pricingTable.red:after{
    background: linear-gradient(45deg, #b53117 49%, transparent 50%) ;
    }
    .pricingTable.red .pricingTable-header,
    .pricingTable.red .pricingTable-signup{
    background: linear-gradient(135deg,#FC5430 25%,#f96852 26%,#f96852 40%,
    #FC5430 41%,#FC5430 47%,#f96852 48%, #f96852 60%, #FC5430 61%);
    }
    @media only screen and (max-width: 990px){
    .pricingTable{ margin: 0 0 30px; }
    }
    @media only screen and (max-width: 576px){
    .pricingTable{ padding: 0 15px 10px; }
    .pricingTable:before{ left: 1px; }
    .pricingTable:after{ right: 1px; }
    .pricingTable .pricing-content li{
    font-size: 15px;
    padding: 0;
    }
    }
    </style>
    @endsection