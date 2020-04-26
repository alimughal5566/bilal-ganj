@extends('layout.backend-layout')

@section('title','Admin - Agent Registeration')

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/admin/css/chosen.css')}}">
@endsection

@section('content')
    <div class="container-fluid mt-1">
        <div class="customer_login mt-3">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6">
                    <div class="account_form register">
                        <h2>Assign Agent to Vendor</h2>
                        @if(Session()->has('success'))
                            <div class="alert alert-success">
                                {{session()->get('success')}}
                            </div>
                        @endif
                        <form action="{{route('assignAgentVender')}}" method="post" class="needs-validation"
                              enctype="multipart/form-data" novalidate>
                            @if($message = Session::get('agentassign'))
                                <div class="alert alert-success">{{$message}}</div>
                            @endif
                            @csrf
                            <p>
                            <div>
                                <label>Agent Name <span>*</span></label>
                                <select class="form-control chosen-select" data-placeholder="--Select Agent--"
                                        name="agent" id="agent" required>
                                    <option value=""></option>
                                    @foreach($allAgent as $agent)
                                        <option value="{{$agent->agent()->first()->id}}">{{$agent->name}}</option>
                                    @endforeach
                                </select>
                                @include('error.error', ['filed' => 'agent'])
                                <div class="invalid-feedback">
                                    Agent Required
                                </div>
                            </div>
                            </p>
                            <p>
                            <div class="side-by-side clearfix">
                                <div>
                                    <label>Select Vendors <span>*</span></label>
                                    <select data-placeholder="--Select Vender--" name="venders[]" multiple="multiple"
                                            class="chosen-select-width" tabindex="16" required>
                                        <option value=""></option>
                                        @foreach($allVender as $vender)
                                            @if($vender->bgShop()->first()->agent_id =="")
                                                <option value="{{$vender->bgShop()->first()->id}}">{{$vender->bgShop()->first()->shop_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('error.error', ['filed' => 'venders'])
                                    <div class="invalid-feedback">
                                        Vender Required
                                    </div>
                                </div>
                            </div>
                            </p>
                            <div class="login_submit">
                                <button type="submit" class="btn btn-success">Assign</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-5 mb-3">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Agent Assign BgShop
                </div>
                <div class="card-body">

                    <div id="no-more-tables">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Agent Id</th>
                                <th>Agent Name</th>
                                <th>BgShop Id</th>
                                <th>BgShop Name</th>
                                <th>BgShop Contact No</th>
                                <th>BgShop Address</th>
                                <th>Agent Assigned</th>
                                <th>UnAssigned Agent</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($allVender as $vender)
                                @php
                                    $bgShop =  $vender->bgShop()->first();
                                    $id = $bgShop->agent_id;
                                @endphp
                                @if($bgShop->agent_id != null)
                                    <tr>
                                        <td data-title="Agent ID">{{$vender->bgShop()->first()->agent_id}}</td>
                                        <td data-title="Agent ID">
                                            @foreach($allAgent as $agent)
                                                @if($agent->agent()->first()->id === $id)
                                                    {{$agent->name}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td data-title="BgShop Id">{{$vender->bgShop()->first()->id}}</td>
                                        <td data-title="BgShop Name">{{$vender->bgShop()->first()->shop_name}}</td>
                                        <td data-title="BgShop Name">{{$vender->contact_number}}</td>
                                        <td data-title="BgShop Name">{{$vender->address}}</td>
                                        <td data-title="Agent Assigned">
                                            <form method="post" class="delete_user_form" action="">
                                                <i class="fas fa-check text-success"
                                                   title="Agent Assign"></i>

                                            </form>
                                        </td>
                                        <td data-title="UnAssigned Agent">
                                                <a onclick="return confirm('Do you really want to unassign agent?')" href="{{route('unassignAgentVender',$vender->bgShop()->first()->id)}}">Unassigned</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{--                @if(isset($latest_update))--}}
                <div class="card-footer small text-muted">Last Entry
                    at
                </div>
                {{--@endif--}}
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('assets/admin/js/chosen.jquery.js')}}"></script>
    <script src="{{asset('assets/admin/js/init.js')}}"></script>
@endsection
