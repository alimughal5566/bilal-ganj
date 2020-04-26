@extends('layout.rider-layout')
@section('title','Schedule Rides')
@section('content','Schedule Rides')
@section('rightPane')
    <div class="col-sm-12 col-md-9 col-lg-9">
        <div class="tab-content dashboard_content">
            <h3>Schedule Rides</h3>
            @if($message = session()->get('success'))
                <div class="alert alert-success">
                    {{$message}}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr class="no_wrap">
                        <th>Order ID</th>
                        <th>Status</th>
                        <th>Customer User Name</th>
                        <th>Customer Number</th>
                        <th>From</th>
                        <th>Destination Address</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($rides))
                        @php
                            $check = false;
                        @endphp
                        @foreach($rides as $ride)
                            @if($ride->status === 1)
                                @php
                                    $check = true;
                                @endphp
                                @break
                            @else
                                {{$check = false}}
                            @endif
                        @endforeach

                        @foreach($rides as $ride)
                            @php
                                $desLat = $ride->destination_latitude;
                                $desLng = $ride->destination_longitude;
                                $client = new \GuzzleHttp\Client();
                                $geocoder = new \Spatie\Geocoder\Geocoder($client);
                                $geocoder->setApiKey(config('geocoder.key'));
                                $address = $geocoder->getAddressForCoordinates($desLat,$desLng);
                                $order = $ride->order()->first();
                                $user = \App\Models\User::find($order->user_id);
                            @endphp
                            <tr class="no_wrap">
                                <input type="hidden" name="product_id"
                                       value="">
                                <td class="product_thumb">
                                    {{$ride->order_id}}
                                </td>
                                <td class="product_name {{$ride->status===0?'text-primary':'text-success'}}">{{$ride->status===0?'pending':'on ride'}}</td>
                                <td>
                                    {{$user->name}}
                                </td>
                                <td>
                                    {{$user->contact_number}}
                                </td>
                                <td class="product-price">
                                    Bilal Ganj
                                </td>
                                <td class="product_quantity">
                                    {{$address['formatted_address']}}
                                </td>
                                <td class="product_total">
                                    @if($ride->status===0 && $check === false)
                                        <a href="{{route('trackRiderView',['ride_id'=>$ride->rider_id,'order_id'=>$ride->order_id])}}">
                                            <button class="btn btn-primary">
                                                Take a Ride
                                            </button>
                                        </a>
                                    @elseif($ride->status === 1)
                                        <a href="{{route('trackRiderView',['ride_id'=>$ride->rider_id,'order_id'=>$ride->order_id, 'flag'=>true])}}">
                                            <button class="btn btn-primary">
                                                View
                                            </button>
                                        </a>
                                    @else
                                        <i class="fa fa-ban"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="7">No Record Found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
