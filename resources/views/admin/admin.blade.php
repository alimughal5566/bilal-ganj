@extends('layout.backend-layout')

@section('title','Admin - Dashboard')

@section('content')

    <div id="content-wrapper">
        <div class="container-fluid">
            @if($message = Session::get('deleteVendor'))
                <div class="alert alert-danger">{{$message}}</div>
            @endif
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Overview</li>
            </ol>

            <!-- Icon Cards-->
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-primary o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-user-circle"></i>
                            </div>
                            <div class="mr-5">{{$arr['total_user']}} Registered User{{($arr['total_user'])>1 ? 's':''}}</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{route('showUserView')}}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-warning o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-list"></i>
                            </div>
                            <div class="mr-5">{{$arr['total_product']}} Product{{($arr['total_product'])>1 ? 's':''}}</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{route('productList')}}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-success o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-comments"></i>
                            </div>
                            <div class="mr-5">{{$arr['total_comment']}} Comment{{($arr['total_comment'])>1 ? 's':''}}</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{route('commentList')}}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-danger o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-shopping-cart"></i>
                            </div>
                            <div class="mr-5">{{$arr['total_order']}} Order{{($arr['total_order'])>1 ? 's':''}}</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{route('orderList')}}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-chart-area"></i>
                    User Registerd in Month
                </div>
                <div class="card-body">
                    <canvas id="myAreaChart" width="100%" height="30"></canvas>
                </div>
                <div class="card-footer small text-muted">Last Updated
                    at {{$time->updated_at->format('d M, Y h:i A')}}</div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    All Users
                </div>
                <div class="card-body">
                    <div id="no-more-tables table-responsive">
                        <table class="table table-responsive table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr class="no_wrap">
                                <th>User Id</th>
                                <th>Type</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Address</th>
                                <th>Is Active</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($allUsers as $user)
                                @if($user->type === 'admin')
                                    @continue
                                @endif
                                <tr>
                                    <td data-title="User ID">{{$user->id}}</td>
                                    <td data-title="Type">{{$user->type}}</td>
                                    <td data-title="User Name">{{$user->name}}</td>
                                    <td data-title="Email">{{$user->email}}</td>
                                    <td data-title="Contact Number">{{$user->contact_number}}</td>
                                    <td data-title="Address">{{$user->address}}</td>
                                    <td data-title="is_active" class="check_active">{{$user->is_active}}</td>
                                    <td data-title="status" class="restore">{{$user->deleted_at===null?'Active':'Blocked'}}</td>
                                    <td data-title="Action">
                                        @if($user->deleted_at!=null)
                                            <a href="{{route('statusActive')}}" class="text-decoration-none status"
                                               id="{{$user->id}}">
                                                <span>UnBlocked</span>
                                            </a>
                                        @else
                                            <a href="{{route('statusActive')}}" class="text-decoration-none status"
                                               id="{{$user->id}}">
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

@endsection
