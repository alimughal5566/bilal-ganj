@extends('layout.agent-layout')

@section('title','Agent Panel')

@section('content',"Vendor's List")

@section('rightPane')
    <div class="col-sm-12 col-md-9 col-lg-9">
        <div class="tab-content dashboard_content">
            <div class="col-lg-9 col-md-7 col-12 my-3 show_remarks">
                <h3>Remarks</h3>
                @foreach($remarks as $remark)
                    @php
                        $id = $remark->user_id;
                        $user = \App\Models\User::find($id);
                    @endphp
                    <div class="bottom_border p-2">
                        <b>{{$user->name}}</b>
                        <small class='float-right text-grey ml-2'>
                            ({{$remark->created_at->format('d M, Y h:i A')}})
                        </small>
                        <br>
                        <span class="pl-5">{{$remark->message}}</span>
                    </div>
                @endforeach
                @if($vendor->is_verified === null || $vendor->is_verified === 'no')
                    <div class="mt-3 mb-3">
                        <label>Give Remarks:</label>
                        @if($message = Session::get('location'))
                            <div class="alert alert-success">
                                {{$message}}
                            </div>
                        @endif
                        <form method="post" action="{{route('verifyLocation')}}"
                              class="remarks-form account_form needs-validation" novalidate>
                            <textarea class="form-control" class="comment" name="message" required></textarea>
                            @csrf
                            <input type="hidden" name="vendor_id" value="{{$vendor->id}}">
                            <input type="hidden" class="geo_lati" name="latitude" value="">
                            <input type="hidden" class="geo_longi" name="longitude" value="">
                            <div class="invalid-feedback">
                                Field is Required
                            </div>
                            <button type="submit" class="btn btn-secondary mt-3 remark_submit ml-0">
                                Submit
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{asset('assets/js/map.js')}}"></script>
@endsection
