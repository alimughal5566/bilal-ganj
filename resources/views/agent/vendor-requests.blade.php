@extends('layout.agent-layout')

@section('title','Agent Panel')

@section('content',"Vendor's Request")

@section('rightPane')
    <div class="col-sm-12 col-md-9 col-lg-9">
        <div class="tab-content dashboard_content">
            <div class="" id="orders">
                <h3>Vendor's Request</h3>
                <div class="table-striped text-center">
                    @if($message = Session::get('location'))
                        <div class="alert alert-success">
                            {{$message}}
                        </div>
                    @elseif($message = Session::get('fakeLocation'))
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Shop Name</th>
                            <th>Address</th>
                            <th>Contact No</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($vendors->first()=== null)
                            <tr class="text-center">
                                <td colspan="6">No Record Found</td>
                            </tr>
                        @endif
                        @foreach($vendors as $vendor)
                            {{! $data = $vendor->user()->first()}}
{{--                            {{dd($data)}}--}}
                            @if($data->is_active==='No')
                                <input type="hidden" name="id" value="{{$vendor->id}}">
                                <tr>
                                    <td>{{$vendor->id}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$vendor->shop_name}}</td>
                                    <td>{{$data->address}}</td>
                                    <td>{{$data->contact_number}}</td>
                                    <td class="text-center">
                                        <a href="{{route('agentRemarks',[$vendor->id])}}">
                                            <button class="btn btn-secondary">
                                                Remark
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="remarkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">Submit Remarks</h5>
                    <button type="button" class="close des_close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true pt-2">&times;</span>
                    </button>
                </div>
                <form method="post" class="account_form remarks-form needs-validation"
                      action="{{route('verifyLocation')}}"
                      novalidate>
                    @csrf
                    <input type="hidden" name="vendor_id" value="">
                    <input type="hidden" class="geo_lati" name="latitude" value="">
                    <input type="hidden" class="geo_longi" name="longitude" value="">
                    <div class="modal-body">
                        <label>Write Remarks</label>
                        <textarea rows="3" name="comment" class="form-control" required></textarea>
                        <div class="invalid-feedback">
                            Remarks Field is Required
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="remark_submit" class="btn btn-secondary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('assets/js/map.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqSTkzPn8PpJBY3Pclu-TTjmGDLzqKMD4&libraries=places&callback=getPosition"
            async defer></script>
@endsection
