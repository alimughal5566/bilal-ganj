@extends('layout.vendor-layout')

@section('title','Advertisement Form')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/advertisement/css/style.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/advertisement/css/responsive2.min.css')}}">
@endsection
@section('rightPane')
    <div class="col-sm-12 col-md-9 col-lg-9">
        <!-- Tab panes -->
        <div class="tab-pane active" id="account-details">
            <h3 class="mb-3">Advertisements Form </h3>
            <div class="login">
                <div class="login_form_container">
                    <div class="account_login_form">
                        <form id="form1" runat="server" action="{{route('saveAds')}}" method="post"
                              class="needs-validation shadow p-5"
                              enctype="multipart/form-data" novalidate>
                            @if($message = Session::get('saveAds'))
                                <div class="alert alert-success">{{$message}}</div>
                            @endif
                            @csrf
                            <input type="hidden" name="bgshop_id"
                                   value="{{isset($vendor)? $vendor->id : Auth::user()->bgShop()->first()->id}}">
                            <div class="row">
                                <div class="col">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mb-1" name="title" value="{{old('title')}}"
                                           required/>
                                    @include('error.error', ['filed' => 'title'])
                                    <div class="invalid-feedback">
                                        Title is Required
                                    </div>
                                </div>
                            </div>
                            <div class="row account_form">
                                <div class="col"><label>Descrition<span class="text-danger">*</span></label>
                                    <textarea rows="3" cols="68" class="mb-1 form-control size"
                                              name="description"
                                              required>{{old('description')}}</textarea>
                                    @include('error.error', ['filed' => 'description'])
                                    <div class="invalid-feedback">
                                        Description is Required
                                    </div>
                                </div>
                            </div>
                            {{--<input type="hidden" value="{{$package->id}}" name="package_id">--}}
                            {{--<input type="hidden" value="{{$vendor->id}}" name="bgshop_id">--}}
                            <div class="row account_form">
                                <div class="col-md-5 col-12">
                                    <label>Discount</label>
                                    <input name="discount" type="number" class="form-control mb-1"/>
                                </div>
                            </div>
                            <div class="row">
                                <p>Display Your Advertisement as<span class="text-danger">*</span></p><br>
                                <div >
                                    <br><input type="radio" name="adds" value="banner" onclick="showBlock(event)"> Banner
                                    <br><input type="radio" name="adds" value="slot1" onclick="showBlock(event)"> Slot1
                                    <br><input type="radio" name="adds" value="slot2" onclick="showBlock(event)"> Slot2
                                    @include('error.error', ['filed' => 'type'])
                                </div>
                            </div>
                            <h3 id="type" class="m-5">Drop your Image in </h3>
                            <div class="row" id="restart">
                                <div class="col-md-10  border offset-1">
                                    <div class="col-md-12 border dropZ1" id="droppable1"
                                         ondragover="allowDrop(event)" ondrop="drop(event)">
                                    </div>
                                    <div class="col-md-6 border dropZone2 "><i><h1 class="animated bounce mt-10">Bilal
                                                Ganj</h1></i><img src="{{asset('assets/images/autu2.jpg')}}"></div>
                                    <div class="col-md-4 dropZone2 float-right">
                                        <div class="col-md-12 border dropZone3" id="droppable2" ondragover="allowDrop(event)"
                                             ondrop="drop(event)"></div>
                                        <div class="col-md-12 border dropZone3" id="droppable3" ondragover="allowDrop(event)"
                                             ondrop="drop(event)"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row pt-3 d-flex justify-content-center">
                                <div class="login_submit">
                                    <button type="submit" class="shadow btn btn-primary">Send Request
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script src="{{asset('assets/advertisement/js/uploadHBR.min.js')}}"></script>
    <script>

        $('#browse_file').on('click', function (e) {
                $('#image').click();
            });
            $('#image').on('change', function (e) {
                var fileInput = this;
                if (fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#img').attr('src', e.target.result)
                    }
                    reader.readAsDataURL(fileInput.files[0])
                }
            });
            let name = null;
            let data = null;

            function drag(ev) {
                ev.dataTransfer.setData("key", ev.target.id);
                name = ev.target.name;
            }

            function allowDrop(evn) {
                evn.preventDefault();
            }

            function drop(ev) {
                ev.preventDefault();
                var data2 = ev.dataTransfer.getData("key");
                ev.target.appendChild(document.getElementById(data2));
                data = ev.target.id;
                console.log(name);
                console.log(data);
            }

            let width1 = null;
            let height1 = null;

            function showBlock(ev) {
                var type = ev.target.value;
                console.log(type);
                if (type === 'banner') {
                    width1 = 300;
                    height1 = 250;
                    // location.reload();
                    // $(".dropZone3").attr("ondragover" , " ");
                    {{--$("#amount").val("{{$package->banner_price}}");--}}
                }
                else if (type === "slot1" || type === "slot2") {
                    width1 = 320;
                    height1 = 100;
                    // location.reload();
                    // $(".dropZ1").attr("ondragover" , " ");
                    {{--$("#amount").val("{{$package->slot1_price}}");--}}
                }
            }

            var _URL = window.URL || window.webkitURL;

            $("#image").change(function (e) {
                var file, img;
                let val = 0;
                if ((file = this.files[0])) {
                    img = new Image();
                    img.onload = function () {

                        alert(this.width + " " + this.height);
                        let imgW = this.width;
                        let imgH = this.height;
                        // console.log(imgH +""+ imgW);
                        if (imgW < width1 && imgH < height1) {
                            alert("Uploaded image should have following dimensions " + width1 + " X " + height1);
                        }
                    };
                    img.onerror = function () {
                        alert("not a valid file: " + file.type);
                    };
                    img.src = _URL.createObjectURL(file);
                }
            });
    </script>
@endsection
