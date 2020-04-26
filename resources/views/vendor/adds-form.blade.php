@extends('layout.vendor-layout')

@section('title','Advertisement on Bilal Ganj')

@section('crumb_class','d-none')
@section('content')
    <a href=''>Back</a>
    @endsection
@section('rightPane')
    <div class="container-fluid">
        <center>
        <h3 class="">{{$typeDetail->type}}</h3>
        <div id="detail" class="mt-5">
            <ul class="ml-5 ads_list">
                <li>Placement : {{$typeDetail->placement}} </li>
                <li>Appearance : {{$typeDetail->appearance}} </li>
                <li>Banner Size : {{$typeDetail->size}} </li>
                <li>Minimum Duration : {{$typeDetail->duration}} days</li>
                <li class="mt-5">
                    <a id="continue" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal">Continue</a>
                </li>
            </ul>
        </div>
        </center>
        `
               <div class="modal fade" id="myModal" role="dialog">
                   <div class="modal-dialog modal-lg">

                       <!-- Modal content-->
                       <div class="modal-content">
                           <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal">&times;</button>
                               <h3 class="">{{$typeDetail->type}}</h3>
                           </div>
                                <div class="modal-body">
                                   <input type="hidden" id="bg_credit" value="{{$vendor->credit}}"/>
                                   <input type="hidden" id="add_credit" value="{{$typeDetail->credits}}" />
                                   <form method="post" action="{{route('saveAds')}}" class="needs-validation shadow p-5"
                                         enctype="multipart/form-data" novalidate>
                                       <input type="hidden" name="bgshop_id" value="{{$vendor->id}}">
                                       <input type="hidden" name="detail_id" value="{{$typeDetail->id}}">
                                       @csrf
                                           <div class="row">
                                               <div class="col-md-12 col-12">
                                                   <label>Title <span class="text-danger">*</span></label>
                                                   <input type="text" class="form-control mb-1" name="title" value="{{old('title')}}" required/>
                                                   @include('error.error', ['filed' => 'title'])
                                                   <div class="invalid-feedback">
                                                       Title is Required
                                                   </div>
                                               </div>
                                           </div>
                                       <div class="row">
                                           <div class="col-md-6 col-12">
                                               <label>Total credit Points </label>
                                               <input id="credits" class="form-control mb-1" name="total_credits" required readonly/>
                                           </div>
                                           <div class="col-md-6">
                                               <label>Duration in days </label>
                                               <input class="form-control mb-1" type="number" name="duration" value="{{$typeDetail->duration}}"/>
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="form-group">
                                               <label class="mt-4 -bold">Upload Image</label>
                                               <div class="input-group">
                                                   <input type="file" class="form-control" name="image" id="imgInp"  required />
                                                   @include('error.error', ['filed' => 'image'])
                                                   <div class="invalid-feedback">
                                                       Image is required
                                                   </div>
                                               </div>
                                               <img id="img-upload" class="w-75 h-50" />
                                           </div>
                                       </div>
                                       <div class="form-row pt-3 d-flex justify-content-center">
                                           <div class="login_submit">
                                               <button type="submit" class="shadow btn btn-primary" id="save">Send Request
                                               </button>
                                           </div>
                                       </div>
                                   </form>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                           </div>
                       </div>
                   </div>
               </div>
    @endsection

@section('styles')
    <style>
        .ads_list li{
            font-weight: bold;
        }
        .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
        }

    </style>
@endsection

@section('scripts')
    <script src="{{asset('assets/js/image-upload.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert-dev.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#leftPane').remove();

            var crdt = $("#add_credit").val();
            var duration = $("input[name=duration]").val();
            var total_crdt = crdt * duration;
            $('#credits').attr('value' , total_crdt);

            $("input[name=duration]").focusout(function () {
                var duration = this.value;
                var total_crdt = crdt * duration;
                $('#credits').attr('value' , total_crdt);
            });

            $('#continue').click(function () {
                $('#detail').hide();
                $('li').removeClass('d-none');
                $('#form').removeClass("hidden");
            });
            $('#back').click(function () {
                $('#detail').show();
                $('#form').addClass("hidden");
            });

            var _URL = window.URL || window.webkitURL;

            var width , height;

            $("#imgInp").change(function(e) {
                var file, img;
                if ((file = this.files[0])) {
                    img = new Image();
                    img.onload = function() {
                         width = this.width;
                         height = this.height;
                        alert("Image dimensions  "+width + "x" + height+"  pixels");
                    };
                    img.onerror = function() {
                        alert( "not a valid file: " + file.type);
                    };
                    img.src = _URL.createObjectURL(file);
                }
            });


            $("#save").click(function () {
                var bgCredit = $("#bg_credit").val();
                var adsCredit = $("#credits").val();
                if (bgCredit <adsCredit)
                {
                    alert('You need to buy credit points for this advertisement ');
                }
            });
        });
    </script>
@endsection