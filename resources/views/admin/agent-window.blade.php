@extends('layout.backend-layout')

@section('title','Admin - Dashboard')

@section('content')

    <div id="content-wrapper">

        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-5 d-flex">
                    <a class="btn btn-primary mb-4 w-50 mr-3" href="{{route('creatAgent')}}">
                        <i class="fas fa-user-plus" style="font-size: 13px"></i>
                        Add &nbsp;Agent
                    </a>
                    <a class="btn btn-success mb-4 text-white w-50" href="{{route('fetchAgentVender')}}">
                        <i class="fas fa-store-alt" style="font-size: 13px"></i>
                        Assign BgShop
                    </a>
                </div>
                <br>
                @if(Session()->has('success'))
                    <div class="alert alert-success">
                        {{session()->get('success')}}
                    </div>
                @endif
            </div>
            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        Registered Agent
                    </div>
                    <div class="card-body">
                        <div id="no-more-tables">
                            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>User_id</th>
                                    <th>Name</th>
                                    <th>Salary</th>
                                    <th>Qualification</th>
                                    <th>Edit Agent</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($allAgent as $agent)
                                    <tr>
                                        {{!$agent1 = $agent->user()->first()}}
                                        <td data-title="User ID">{{$agent['user_id']}}</td>
                                        <td data-title="First Name">{{$agent1['name']}}</td>
                                        <td data-title="Salary">{{$agent['salary']}}</td>
                                        <td data-title="Qualification/Skills">{{$agent['qualification']}}</td>
                                        <td data-title="Edit Agent">
                                            <a href="{{route('editAgentForm',$agent['user_id'])}}"><h3><i
                                                            class="fas fa-user-edit"></i></h3></a>
                                        </td>
                                        <td data-title="Action">
                                            <a onclick="return confirm('Do you really want to delete agent?')" href="{{route('deleteAgent',$agent['user_id'])}}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer small text-muted">Last Updated at {{$time->updated_at->format('d M, Y h:i A')}}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
