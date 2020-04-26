@extends('layout.backend-layout')

@section('title','Admin-Panel')

@section('content')
    <div id="content-wrapper">

        <div class="container-fluid">
            @if($message = Session::get('success'))
                <div class="alert alert-success mb-3">
                    {{$message}}
                </div>
            @endif
            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Comment Details
                </div>
                <div class="card-body">
                    <div id="no-more-tables">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Comment ID</th>
                                <th>Message</th>
                                <th>Commented By</th>
                                <th>Product ID</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Delete Comment</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <?php
                                    $user_name = $comment->user()->first()->name;
                                ?>
                                <tr>
                                    <td data-title="Comment ID">{{$comment->id}}</td>
                                    <td data-title="Message">{{$comment->message}}</td>
                                    <td data-title="Commented By">{{$user_name}}</td>
                                    <td data-title="Product ID">{{$comment->product()->first()->id}}</td>
                                    <td data-title="Date">{{$comment->updated_at->format('d M, Y')}}</td>
                                    <td data-title="Time">{{$comment->updated_at->format('h:i A')}}</td>
                                    <td data-title="Delete Comment">
                                        <a onclick="return confirm('Do you really want to delete Comment?')"
                                           href="{{route('deleteComment',$comment->id)}}"><i
                                                class="fa fa-trash text-danger"></i></a>
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
