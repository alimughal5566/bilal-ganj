@extends('layout.backend-layout')

@section('title','Admin - Dashboard')

@section('content')

    <div id="content-wrapper">

        <div class="container-fluid">
            <!-- DataTables Example -->
            <div class="row m-1">
                <img class="user-img" src="assets/images/architect.jpg">
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Registered User
                </div>
                <div class="card-body">
                    <div id="no-more-tables">
                        <table class="table table-responsive table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
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
                            @foreach($users as $user)
                                @if($user->type==='admin')
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
