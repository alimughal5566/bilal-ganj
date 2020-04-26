@extends('layout.backend-layout')

@section('title','Admin - Dashboard')

@section('content')

    <div id="content-wrapper">

        <div class="container-fluid">
            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        <b>Registered Vendors</b>
                    </div>
                    <div class="card-body">

                        <div id="no-more-tables">
                            <table class="table table-responsive table-bordered text-center" id="dataTable" width="100%"
                                   cellspacing="0">
                                <thead class="bg-grey">
                                <tr class="no_wrap">
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Shop Name</th>
                                    <th>Current Credits</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Contact No</th>
                                    <th>Opening Time</th>
                                    <th>Closing Time</th>
                                    <th>Is_Atcive</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vendors as $vendor)
                                    <tr>
                                        <td data-title="User ID">{{$vendor['id']}}</td>
                                        <td data-title="First Name">{{$vendor['name']}}</td>
                                        <td data-title="Shop Name">{{$vendor->bgShop()->first()->shop_name}}</td>
                                        <td data-title="Current Credits">{{$vendor->bgShop()->first()->credit}}</td>
                                        <td data-title="address">{{$vendor['address']}}</td>
                                        <td data-title="Email">{{$vendor['email']}}</td>
                                        <td data-title="Contact No">{{$vendor['contact_number']}}</td>
                                        <td data-title="Opening Time">{{$vendor->bgShop()->first()->opening_time}}</td>
                                        <td data-title="Closing Time">{{$vendor->bgShop()->first()->closing_time}}</td>
                                        <td data-title="is_active" class="check_active">{{$vendor['is_active']}}</td>
                                        <td data-title="status"
                                            class="restore">{{$vendor['deleted_at']===null?'Active':'Blocked'}}</td>
                                        <td data-title="Action">
                                            @if($vendor['deleted_at']!=null)
                                                <a href="{{route('statusActive')}}" class="text-decoration-none status"
                                                   id="{{$vendor['id']}}">
                                                    <span>UnBlocked</span>
                                                </a>
                                            @else
                                                <a href="{{route('statusActive')}}" class="text-decoration-none status"
                                                   id="{{$vendor['id']}}">
                                                    <span>Blocked</span>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer small text-muted">Last Updated
                        at {{$time->updated_at->format('d M, Y h:i A')}}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
