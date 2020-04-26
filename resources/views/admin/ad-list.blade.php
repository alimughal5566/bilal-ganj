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
                    Advertisment Requests
                </div>
                <div class="card-body">
                    <div id="no-more-tables">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Bgshop Id</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($allAd as $ad)
                                <tr>
                                    <td data-title="AD ID">{{$ad->id}}</td>
                                    <td data-title="BgShop ID">{{$ad->bgshop_id}}</td>
                                    <td data-title="Title">{{$ad->title}}</td>
                                    <td data-title="Description">{{$ad->description}}</td>
                                    <td data-title="Status">{{$ad->status}}</td>

                                    <td data-title="Approve">
                                        @if($ad->status == 'pending')
                                            <a class="btn btn-primary" href="{{route('approveAd',$ad->id)}}">Approve</a> / <a class="btn btn-primary" href="{{route('rejectAd',$ad->id)}}">Reject</a>
                                        @elseif($ad->status == 'approved')
                                            <a class="btn btn-primary" id="apButton">Approved</a>
                                        @elseif($ad->status == 'rejected')
                                            <a class="btn btn-primary " id="rjButton">Reject</a>
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
