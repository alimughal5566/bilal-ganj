@extends('layout.rider-layout')
@section('title','History')
@section('content','History')
@section('rightPane')
    <div class="col-sm-12 col-md-9 col-lg-9">
        <div class="tab-content dashboard_content">
            <h3>History</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Delivered To</th>
                        <th>From</th>
                        <th>Destination Address</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($rides))
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
                                <td>{{$user->name}}</td>
                                <td class="product-price">
                                    Bilal Ganj
                                </td>
                                <td class="product_quantity">
                                    {{$address['formatted_address']}}
                                </td>
                                <td class="product_name text-success">Delivered</td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="5">No Record Found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
