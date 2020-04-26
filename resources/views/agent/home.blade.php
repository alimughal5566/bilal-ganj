@extends('layout.agent-layout')

@section('title','Agent Panel')

@section('content',"Vendor's List")

@section('rightPane')
    <div class="col-sm-12 col-md-9 col-lg-9">
        <div class="tab-content dashboard_content">
            <div class="" id="orders">
                <h3>Vendor's List</h3>
                <div class="table-striped text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Shop Name</th>
                            <th>Address</th>
                            <th>Contact No</th>
                            <th>Credits</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($users->first()=== null)
                                <tr class="text-center">
                                    <td colspan="6">No Record Found</td>
                                </tr>
                        @endif
                        @foreach($users as $user)
                            {{! $data = $user->user()->first()}}
                            @if($data->is_active==='Yes')
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->shop_name}}</td>
                                    <td>{{$data->address}}</td>
                                    <td>{{$data->contact_number}}</td>
                                    <td>{{$user->credit}}</td>
                                    <td><a href="{{route('vendorPanel',$user->user_id)}}" class="view">Manage</a></td>

                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
