@extends('layout.backend-layout')

@section('title','Admin - Dashboard')

@section('content')

    <div id="content-wrapper">

        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-3">
                    <a class="btn btn-success mb-4 w-100" href="{{route('addRiderView')}}">
                        <i class="fa fa-motorcycle" style="font-size: 13px"></i>
                        Add Rider
                    </a>
                </div>
                <div class="col-md-9 text-center">
                    @if(Session()->has('success'))
                        <div class="alert alert-success">
                            {{session()->get('success')}}
                        </div>
                    @endif
                </div>
            </div>
            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        Registered Riders
                    </div>
                    <div class="card-body">
                        <div id="no-more-tables">
                            <table class="table table-bordered table-responsive text-center" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr class="no_wrap">
                                    <th>UserID</th>
                                    <th>User Name</th>
                                    <th>Salary</th>
                                    <th>Vehicle Type</th>
                                    <th>Vehicle Number</th>
                                    <th>Working Status</th>
                                    <th>Contact Number</th>
                                    <th>Edit</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($riders as $rider)
                                    <tr>
                                        {{!$rider1 = $rider->user()->first()}}
                                        <td data-title="UserID">{{$rider['user_id']}}</td>
                                        <td data-title="User Name">{{$rider1['name']}}</td>
                                        <td data-title="Salary">{{$rider['salary']}}</td>
                                        <td data-title="Vehicle Type">{{$rider['vehicle_type']}}</td>
                                        <td data-title="Vehicle Number">{{$rider['vehicle_number']}}</td>
                                        <td data-title="Working Status">{{$rider['status']}}</td>
                                        <td data-title="Contact Number">{{$rider1['contact_number']}}</td>
                                        <td data-title="Edit">
                                            <a href="{{route('editRiderForm',$rider['user_id'])}}">
                                                <i class="fa fa-edit text-dark"></i></a>
                                        </td>
                                        <td data-title="Action">
                                            <a onclick="return confirm('Do you really want to delete Rider?')"
                                               href="{{route('deleteRider',$rider['user_id'])}}"><i
                                                    class="fa fa-trash text-danger block_rider"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(isset($time))
                        <div class="card-footer small text-muted">Last Updated at {{$time->updated_at->format('d M, Y h:i A')}}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
