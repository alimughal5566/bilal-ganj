@extends('layout.backend-layout')

@section('title','Admin-Panel')

@section('content')
    <div id="content-wrapper">

        <div class="container-fluid">
        <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Order Details
                </div>
                <div class="card-body">
                    <div id="no-more-tables">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Order By</th>
                                <th>Delivery Man</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Delivery Date</th>
                                <th>Estimated Delivery Time</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                @php
                                    $date = date('d-M-Y',strtotime($order->estimated_time));
                                    $estimatedTime = date('h:i:s',strtotime($order->estimated_time));
                                    $user = $order->user()->first();
                                    $ride = $order->riderLog()->first();
                                    $ride = $order->riderLog()->first();
                                    $rider = \App\Models\Rider::find($ride->rider_id);
                                    $riderUser = $rider->user()->first();
                                @endphp
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$riderUser->name}}</td>
                                    <td>{{$order->status}}
                                    <td>RS. {{$order->amount}}</td>
                                    <td>{{$date}}</td>
                                    <td>{{$estimatedTime}}</td>
                                    <td><a href="{{route('adminOrderDetails',['id'=>$order->id])}}">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(isset($time))
                    <div class="card-footer small text-muted">Last Entry
                    at {{$time->updated_at->format('d M, Y h:i A')}}</div>
                @endif
            </div>

        </div>
    </div>
@endsection
