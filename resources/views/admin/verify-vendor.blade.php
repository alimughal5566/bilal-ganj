@extends('layout.backend-layout')

@section('title','Admin Profile')
@section('content')
    @if($vendor != null)
        <div id="content-wrapper">
            @if($vendor->user()->first())
                @php
                    $user = $vendor->user()->first();
                @endphp
                <div class="container-fluid">
                    @if($message = Session::get('verifyMes'))
                        <div class="alert alert-success">{{$message}}</div>
                    @endif

                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table"></i>
                            Requested User
                        </div>
                        <div class="card-body">
                            <div id="no-more-tables">
                                <table class="table table-responsive table-bordered text-center" id="" width="100%"
                                       cellspacing="0">
                                    <thead>
                                    <tr class="no_wrap">
                                        <th>Vendor Id</th>
                                        <th>Name</th>
                                        <th>Shop Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Contact Number</th>
                                        <th>Is Active</th>
                                        <th>Action</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td data-title="User ID">{{$vendor->id}}</td>
                                        <td data-title="Type">{{$user->name}}</td>
                                        <td data-title="User ID">{{$vendor->shop_name}}</td>
                                        <td data-title="User Name">{{$user->email}}</td>
                                        <td data-title="Email">{{$user->address}}</td>
                                        <td data-title="Contact Number">{{$user->contact_number}}</td>
                                        <td data-title="is_active" class="check_active">{{$user->is_active}}</td>
                                        @if($user->is_active==='No')
                                            <td data-title="Block">
                                                <input type="hidden" name="vendor_id" value="{{$vendor->user_id}}">
                                                <i class="fa fa-trash text-danger delete_user"
                                                   title="Delete User"></i>
                                            </td>
                                        @else
                                            <td data-title="Status">
                                                <span class="text-success">Verified</span>
                                            </td>
                                        @endif
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" id="latitude" value="{{$currentLocation->latitude}}">
                    <input type="hidden" id="longitude" value="{{$currentLocation->longitude}}">
                    <input type="hidden" id="vendorLati" value="{{$user->latitude}}">
                    <input type="hidden" id="vendorLongi" value="{{$user->longitude}}">
                    <div id="map" class="mt-5" style="width: 100%; height: 350px;">
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-5 col-12">
                            <div class="mt-3">
                                <button class="btn btn-secondary mb-4 distance_cal">
                                    Calculate Distance
                                </button>
                                <input type="text" placeholder="at max 2-Km" value=""
                                       class="form-control my_field distance_field mb-3"
                                       readonly>
                                @if($user->is_active === 'No')
                                    <a href="{{route('changeStatus',['id'=>$vendor->user_id])}}">
                                        <button class="btn btn-success p-2 mr-2">
                                            Approve
                                        </button>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-7 col-12 my-3 show_remarks">
                            <h3>Remarks</h3>
                            @foreach($remarks as $remark)
                                @php
                                    $id = $remark->user_id;
                                    $data = \App\Models\User::find($id);
                                @endphp
                                <div class="bottom_border p-2">
                                    <b>{{$data->name}}</b>
                                    <small class='float-right text-grey ml-2'>
                                        ({{$remark->created_at->format('d M, Y h:i A')}})
                                    </small>
                                    <br>
                                    <span class="pl-5">{{$remark->message}}</span>
                                </div>
                            @endforeach
                            @if($user->is_active === 'No')
                                <div class="mt-3 mb-3">
                                    <label>Give Remarks:</label>
                                    @if($message = Session::get('location'))
                                        <div class="alert alert-success">
                                            {{$message}}
                                        </div>
                                    @endif
                                    <form method="post" action="{{route('verifyLocation')}}"
                                          class="remarks-form account_form needs-validation" novalidate>
                                        <textarea class="form-control" name="message" required></textarea>
                                        @csrf
                                        <input type="hidden" name="vendor_id" value="{{$vendor->id}}">
                                        <input type="hidden" class="geo_lati" name="latitude" value="">
                                        <input type="hidden" class="geo_longi" name="longitude" value="">
                                        <div class="invalid-feedback">
                                            Field is Required
                                        </div>
                                        <button type="submit" class="btn btn-secondary mt-3 p-2 remark_submit">
                                            Submit
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    @endif
    @else
        <img class="w-50 h-50" src={{asset('assets/frontend/img/NoRecordFound2.png')}}>
    @endif
@endsection
@section('scripts')
    <script src="{{asset('assets/js/map.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqSTkzPn8PpJBY3Pclu-TTjmGDLzqKMD4&libraries=places&callback=init"
            async defer></script>
@endsection
