@extends('layout.vendor-layout')

@section('title','Advertisement Form')

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
                                {{--<input type="hidden" value="slot1" name="type">--}}
                                @if($mes = Session::get('request'))
                                    <div class="alert alert-success">{{$mes}}</div>
                                @endif
                            <div class="row">
                                <div class="col">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mb-1 border border-dark" name="title" value="{{old('title')}}"
                                           required/>
                                    @include('error.error', ['filed' => 'title'])
                                    <div class="invalid-feedback">
                                        Title is Required
                                    </div>
                                </div>
                            </div>
                            <div class="row account_form">
                                <div class="col"><label>Descrition<span class="text-danger">*</span></label>
                                    <textarea rows="3" cols="68" class="mb-1 form-control size border border-dark"
                                              name="description"
                                              required>{{old('description')}}</textarea>
                                    @include('error.error', ['filed' => 'description'])
                                    <div class="invalid-feedback">
                                        Description is Required
                                    </div>
                                </div>
                            </div>
                                <div style="visibility: hidden">
                                    <ul>
                                    @foreach($adtypes as $addtype)
                                        <li class="{{$addtype->type}}" value="{{$addtype->credits}}"></li>
                                        <li class="duration{{$addtype->type}}" value="{{$addtype->duration}}"></li>
                                        @endforeach
                                    </ul>
                                </div>
                            <div class="container-fluid" id="addArea" style="visibility: visible">
                                <div class="row">
                                    <div class="col-md-12 p-2">
                                        <label><h3>Select image for your Advertisement</h3><span class="text-danger">*</span></label>
                                        <div class="row p-3">
                                            <input type="file" name="photo" id="photo1" class="display">
                                            <input type="file" name="photo2" id="photo2" class="display">
                                            <input type="file" name="photo3" id="photo3" class="display">

                                            <table class="m-3">
                                                <tr>
                                                    <td class="border border-dark dummyImg" >
                                                        <img src="{{asset('assets/advertisement/images/images.jpg')}}" name="photo" id="image1" type="banner" class="img" draggable="true"
                                                             ondragstart="drag(event)">
                                                    </td>
                                                </tr>
                                                <tr class="ml-3">
                                                    <td>
                                                        <input type="button" name="" value="Browse" id="browse_file1"
                                                               class="btn btn-primary form-control">
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="m-3">
                                                <tr>
                                                    <td class="border border-dark dummyImg">
                                                        <img src="{{asset("assets/advertisement/images/images.png")}}" name="photo2" id="image2" class="img" draggable="true"
                                                             ondragstart="drag(event)">
                                                    </td>
                                                </tr>
                                                <tr class="ml-3">
                                                    <td>
                                                        <input type="button" name="" value="Browse" id="browse_file2"
                                                               class="btn btn-primary form-control">
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="m-3" >
                                                <tr>
                                                    <td class="border border-dark dummyImg">
                                                        <img src="{{asset("assets/advertisement/images/img-icon.png")}}" name="photo3" id="image3" class="img" draggable="true" ondragstart="drag(event)">
                                                    </td>
                                                </tr>
                                                <tr class="ml-3">
                                                    <td>
                                                        <input type="button" name="" value="Browse" id="browse_file3" class="btn btn-primary form-control">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        @include('error.error', ['filed' => 'photo'])
                                        <div class="invalid-feedback">
                                        Image is Required
                                        </div>
                                    </div>

                                </div>
                                <div class="mt-5" style="visibility: hidden">
                                    <label class="font-weight-bold">Total Price in Credits Points<br></label>
                                    <input class="form-control border border-dark totalCredits" readonly value="" name="credits" id="totalCredits">
                                </div>
                                <div class="row mt-5" id="restart">
                                    <div class="col-md-11 ml-4 p-4 border border-dark">
                                        <div>
                                            <a class="cross"><i class="fa fa-times"></i></a>
                                            <div class="col-md-12 border dropZ1 border border-dark" id="drop-1"
                                                 ondragover="allowDrop(event)" ondrop="drop(event)"></div>
                                        </div>
                                            <div class="col-md-6 border dropZone2"><img class="mt-5" id="ads_logo" src="{{asset('assets/frontend/img/logo/icon2.png')}}">
                                        </div>
                                        <div class="col-md-4 m-2 float-right">
                                            <div>
                                                <a class="cross" ><i class="fa fa-times"></i></a>
                                                <div class="col-md-12 border dropZone3 border border-dark" id="drop-2" ondragover="allowDrop(event)"
                                                     ondrop="drop(event)"></div>
                                            </div>
                                            <div>
                                                <a class="cross" ><i class="fa fa-times"></i></a>
                                                <div class="col-md-12 border dropZone3 border border-dark mt-2" id="drop-3" ondragover="allowDrop(event)"
                                                     ondrop="drop(event)"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row pt-3 d-flex justify-content-center">
                                    <div class="login_submit">
                                        <button type="submit" class="shadow btn btn-primary">Send Request
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('showRequired')
    <div class="mt-5">
        <label class="font-weight-bold">Total Price in Credits Points<br></label>
        <input class="form-control border border-dark totalCredits" readonly value="" name="total_credits" id="">
{{--        <label class="font-weight-bold">Duration</label>--}}
{{--        <input class="form-control border border-dark duration" readonly value="" name="duration">--}}
    </div>
@endsection
@section('scripts')

    <script type="text/javascript">
        $(document).ready(function () {
            if($('#image1').attr('src')==='http://127.0.0.1:8000/assets/advertisement/images/images.jpg'){
                $('#image1').attr('draggable','false');
            }
            if($('#image2').attr('src')==='http://127.0.0.1:8000/assets/advertisement/images/images.png'){
                $('#image2').attr('draggable','false');
            }
            if($('#image3').attr('src')==='http://127.0.0.1:8000/assets/advertisement/images/img-icon.png'){
                $('#image3').attr('draggable','false');
            }
        });

        $(".cross").click(function () {

        var img = $(this).siblings().empty();
        console.log(img);
        });
        $('#browse_file1').on('click', function (e) {
            $('#photo1').click();
        });
        $('#browse_file2').on('click', function (e) {
            $('#photo2').click();
        });
        $('#browse_file3').on('click', function (e) {
            $('#photo3').click();
        });

        $('#photo1').on('change', function (e) {
            var fileInput = this;
            if (fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image1').attr('src', e.target.result);
                    if ($('#drop-1').html() != ""){
                        $('#img1').attr('src', e.target.result);
                    }
                }
                reader.readAsDataURL(fileInput.files[0]);
            }
        });

        $('#photo2').on('change', function (e) {
            var fileInput = this;
            var img = "";
            if (fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    img = e.target.result;
                    $('#image2').attr('src', e.target.result);

                    if ($('#drop-2').html() != ""){
                        $('#img2').attr('src', img);
                    }
                }
                reader.readAsDataURL(fileInput.files[0]);

            }
        });

        $('#photo3').on('change', function (e) {
            var fileInput = this;
            if (fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image3').attr('src', e.target.result);
                    if ($('#drop-3').html() != ""){
                        $('#img3').attr('src', e.target.result);
                    }
                }
                reader.readAsDataURL(fileInput.files[0]);
            }
        });

        let width1 = 950;
        let height1 = 300;
        function showBlock(ev) {
            var type = ev.target.value;
            if (type === 'banner')
            {
                width1 = 300 ;
                height1 = 250 ;
                $(".dropZone3").style ="visibility:hidden";
            }
            if(type === "slot1" || type === "slot2")
            {
                width1 = 320 ;
                height1 = 100 ;
                $(".dropZ1").append().style ="visibility:hidden";
            }
            document.getElementById('addArea').style="visibility : visible";

        }

        // making image dragable when there is no dummy image in img tag

        var _URL = window.URL || window.webkitURL;
        $("#photo1").change(function(e) {
            var file, img ;
            let val = 0 ;
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function() {
                    let imgW = this.width;
                    let imgH = this.height;
                    if( imgW > 950 && imgH > 300 )
                    {
                        $('#image1').attr('draggable','ture');
                    }
                    else {
                        $('#image1').attr('src','http://127.0.0.1:8000/assets/advertisement/images/images.jpg');

                        alert("Image dimension should be " +width1+ " X " + height1);
                    }
                };
                img.onerror = function() {
                    alert( "not a valid file: " + file.type);
                };
                img.src = _URL.createObjectURL(file);
            }
        });

        var _URL = window.URL || window.webkitURL;
        $("#photo2").change(function(e) {
            var file, img ;
            let val = 0 ;
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function() {
                    let imgW = this.width;
                    let imgH = this.height;
                    if( imgW > 100 && imgH >100 )
                    {
                        $('#image2').attr('draggable','ture');
                    }
                    else {
                        $('#image2').attr('src','http://127.0.0.1:8000/assets/advertisement/images/images.png');

                        alert("Uploaded image should have following dimensions " +width1+ " X " + height1);
                    }
                };
                img.onerror = function() {
                    alert( "not a valid file: " + file.type);
                };
                img.src = _URL.createObjectURL(file);
            }
        });

        var _URL = window.URL || window.webkitURL;
        $("#photo3").change(function(e) {
            var file, img ;
            let val = 0 ;
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function() {
                    let imgW = this.width;
                    let imgH = this.height;
                    if( imgW > 100 && imgH >100 )
                    {
                        $('#image3').attr('draggable','ture');
                    }
                    else {
                        $('#image3').attr('src','http://127.0.0.1:8000/assets/advertisement/images/img-icon.png');

                        alert("Uploaded image should have following dimensions " +width1+ " X " + height1);
                    }
                };
                img.onerror = function() {
                    alert( "not a valid file: " + file.type);
                };
                img.src = _URL.createObjectURL(file);
            }
        });

        var _URL = window.URL || window.webkitURL;
        $("#drop-1").change(function(e) {
            var file, img ;
            let val = 0 ;
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function() {
                    let imgW = this.width;
                    let imgH = this.height;
                    if( imgW > 100 && imgH >100 )
                    {
                    }
                    else {
                        alert("Uploaded image should have following dimensions " +width1+ " X " + height1);
                    }
                };
                img.onerror = function() {
                    alert( "not a valid file: " + file.type);
                };
                img.src = _URL.createObjectURL(file);
            }
        });

        // DRAG AND DROP FUNCTUNALITY BOSS

        var a = document.getElementById("drop-1").innerHTML;
        var b = document.getElementById("drop-2").innerHTML;
        var c = document.getElementById("drop-3").innerHTML;
        var x = document.getElementById("img1");
        var y = document.getElementById("img2");
        var z = document.getElementById("img3");
        var glob="";

        function allowDrop(ev) {
            ev.preventDefault();
        }

        var value = null;

        function drag(ev) {
            glob=ev.target.id;
            ev.dataTransfer.setData("text", ev.target.id);
        }
        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            // let eleement = document.getElementById(data).cloneNode(true);
            if ( ev.target.id != "img1" && ev.target.id != "img2" && ev.target.id != "img3" ){
                console.log(glob , data);
                ev.target.appendChild( document.getElementById(data));
                rearrangeValue('a');
            }
            else if($('#'+ev.target.id).children('img') && glob != 'image1' && glob != 'image2' && glob != 'image3')
            {
                $drag_parent = $('#'+glob).parent('div').attr('id');
                var changVal=$drag_parent;
                var x = $('#'+ev.target.id).parent('div').html();
                ev.preventDefault();
                $('#'+ev.target.id).parent('div').html(document.getElementById(data));
                $('#'+ev.target.id).parent('div').children('img').attr('id',$('#'+ev.target.id).parent('div').attr('id'));
                $('#'+changVal).html(x);
                rearrangeValue('b');
            }
            console.log("here is drag parent value"+ changVal);
        }

        function rearrangeValue(a) {
            if ($('#image1').attr('src') === 'http://127.0.0.1:8000/assets/advertisement/images/images.jpg') {
            }
            else
                {
                if (a == 'b') {
                    $('.dummyImg').eq(0).html('<img src="http://127.0.0.1:8000/assets/advertisement/images/images.jpg" name="photo1" draggable="false" ondragstart="drag(event)" id="image1" style="height: inherit; width: 100%" class="img">');
                } else if ($('#image1').attr('src') != 'http://127.0.0.1:8000/assets/advertisement/images/images.jpg' && $('#drop-1').html() != "") {

                } else if (a == 'a' && $('#drop-1').html() == "") {
                    $('.dummyImg').eq(0).html('<img src="http://127.0.0.1:8000/assets/advertisement/images/images.jpg" name="photo1" draggable="false" ondragstart="drag(event)" id="image1" style="height: inherit; width: 100%" class="img">');
                }
            }

            var input = document.createElement("input");
            input.identifier = "";
            input.name = "";
            input.className = "display";

            if ($('#drop-1').html() != "") {
                input.value = $('#image1').attr('src');
                $('#drop-1').children('img').attr('id', 'img1');
                $('#drop-1').children('img').attr('name', 'image1');
                var d1 = $('#drop-1').html();
                $('.dummyImg').eq(0).html(d1);
                $('.dummyImg').eq(0).children('img').attr('id', 'image1');

                input.setAttribute("name", "photoLeadboard");
                input.setAttribute("id", "photoLeadboard");
                value = value + ($(".Banner").val() * $(".durationBanner").val());
                document.getElementById("drop-1").appendChild(input);

                var imgStore = $('#image1').attr('src');
                $('#advPic1').val(imgStore);
            } else {
                if ($('.dummyImg').eq(0).children('img').attr('src') == 'http://127.0.0.1:8000/assets/advertisement/images/images.jpg') {
                    $('.dummyImg').eq(0).html('<img src="http://127.0.0.1:8000/assets/advertisement/images/images.jpg" name="photo1" draggable="false" ondragstart="drag(event)" id="image1" style="height: inherit; width: 100%" class="img">');
                }
            }

            if ($('#image2').attr('src') === 'http://127.0.0.1:8000/assets/advertisement/images/images.png' && $('#drop-2').html() == "") {
            } else {
                if (a == 'b') {

                    $('.dummyImg').eq(1).html('<img src="http://127.0.0.1:8000/assets/advertisement/images/images.png" name="photo2" draggable="false" ondragstart="drag(event)" id="image2" style="height: inherit; width: 100%" class="img">');
                } else if ($('#image2').attr('src') != 'http://127.0.0.1:8000/assets/advertisement/images/images.png' && $('#drop-2').html() == "") {

                } else if (a == 'a' && $('#drop-2').html() == "") {
                    $('.dummyImg').eq(1).html('<img src="http://127.0.0.1:8000/assets/advertisement/images/images.png" name="photo2" draggable="false" ondragstart="drag(event)" id="image2" style="height: inherit; width: 100%" class="img">');
                }
                //
                // //Here Murriam code statrt
                // function drop(ev) {
                //     ev.preventDefault();
                //     var data2 = ev.dataTransfer.getData("key");
                //     data = ev.target.id;
                //     var child = ev.target.appendChild(document.getElementById(data2).cloneNode(true));
                //     var src = child.src;
                //     var input = document.createElement("input");
                //     input.value = src;
                //     input.identifier = "";
                //     input.name = "";
                //     input.className = "display";
                //     if (data == "drop1") {
                //         input.setAttribute("name", "photoLeadboard");
                //         input.setAttribute("id", "photoLeadboard");
                //         value = value + ($(".Banner").val() * $(".durationBanner").val());
                //     } else if (data == "drop2") {
                //         input.setAttribute("id", "slot1");
                //         input.setAttribute("name", "photoSlot1");
                //         value = value + ($(".Top-Right-Slot").val() * $(".durationTop-Right-Slot").val());
                //     } else if (data == "drop3") {
                //         input.setAttribute("id", "slot2");
                //         input.setAttribute("name", "photoSlot2");
                //         value = value + ($(".Right-bottom-Slot").val() * $(".durationRight-bottom-Slot").val());
                //     }
                //     $('.totalCredits').val(value);
                //     ev.target.appendChild(input);
                //     console.log(data, data2);
                //     console.log(name);
                //     console.log(input);
                // }
                //
                // //Here murriam code End

                //Here Ali code Start
                if ($('#drop-2').html() != "") {
                    input.value = $('#image2').attr('src');
                    $('#drop-2').children('img').attr('id', 'img2');
                    $('#drop-2').children('img').attr('name', 'image2');
                    var d2 = $('#drop-2').html();
                    $('.dummyImg').eq(1).html(d2);
                    $('.dummyImg').eq(1).children('img').attr('id', 'image2');

                    input.setAttribute("id", "slot1");
                    input.setAttribute("name", "photoSlot1");
                    value = value + ($(".Top-Right-Slot").val() * $(".durationTop-Right-Slot").val());
                    document.getElementById("drop-2").appendChild(input);


                    var imgStore = $('#image2').attr('src');
                    $('#advPic2').val(imgStore);
                } else {
                    if ($('.dummyImg').eq(1).children('img').attr('src') == 'http://127.0.0.1:8000/assets/advertisement/images/images.png') {
                        $('.dummyImg').eq(1).html('<img src="http://127.0.0.1:8000/assets/advertisement/images/images.png" name="photo2" draggable="false" ondragstart="drag(event)" id="image2" style="height: inherit; width: 100%" class="img">');
                    }
                    var imgStore = $('#image2').attr('src');
                    $('#advPic2').val(imgStore);
                }

                if ($('#image3').attr('src') === 'http://127.0.0.1:8000/assets/advertisement/images/img-icon.png' && $('#drop-3').html() == "") {
                } else {
                    if (a == 'b') {
                        $('.dummyImg').eq(2).html('<img src="http://127.0.0.1:8000/assets/advertisement/images/img-icon.png" name="photo3" draggable="false" ondragstart="drag(event)" id="image3" style="height: inherit; width: 100%" class="img">');
                    } else if ($('#image3').attr('src') != 'http://127.0.0.1:8000/assets/advertisement/images/img-icon.png' && $('#drop-3').html() == "") {
                    } else if (a == 'a' && $('#drop-3').html() == "") {
                        $('.dummyImg').eq(2).html('<img src="http://127.0.0.1:8000/assets/advertisement/images/img-icon.png" name="photo3" draggable="false" ondragstart="drag(event)" id="image3" style="height: inherit; width: 100%" class="img">');
                    }
                }

                if ($('#drop-3').html() != "") {
                    $('#drop-3').children('img').attr('id', 'img3');
                    $('#drop-3').children('img').attr('name', 'image3');
                    var d3 = $('#drop-3').html();
                    $('.dummyImg').eq(2).html(d3);
                    $('.dummyImg').eq(2).children('img').attr('id', 'image3');

                    var imgStore = $('#image3').attr('src');
                    $('#advPic3').val(imgStore);
                } else {
                    if ($('.dummyImg').eq(2).children('img').attr('src') == 'http://127.0.0.1:8000/assets/advertisement/images/img-icon.png') {
                        $('.dummyImg').eq(2).html('<img src="http://127.0.0.1:8000/assets/advertisement/images/img-icon.png" name="photo3" draggable="false" ondragstart="drag(event)" id="image3" style="height: inherit; width: 100%" class="img">');
                    }
                }

                if ($('#drop-3').html() != "") {
                    input.value = $('#image3').attr('src');
                    $('#drop-3').children('img').attr('id', 'img3');
                    $('#drop-3').children('img').attr('name', 'image3');
                    var d3 = $('#drop-3').html();
                    $('.dummyImg').eq(2).html(d3);
                    $('.dummyImg').eq(2).children('img').attr('id', 'image3');

                    input.setAttribute("id", "slot2");
                    input.setAttribute("name", "photoSlot2");
                    value = value + ($(".Right-bottom-Slot").val() * $(".durationRight-bottom-Slot").val());
                    document.getElementById("drop-3").appendChild(input);

                    var imgStore = $('#image3').attr('src');
                    $('#advPic3').val(imgStore);
                } else {
                    if ($('.dummyImg').eq(2).children('img').attr('src') == 'http://127.0.0.1:8000/assets/advertisement/images/img-icon.png') {
                        $('.dummyImg').eq(2).html('<img src="http://127.0.0.1:8000/assets/advertisement/images/img-icon.png" name="photo3" draggable="false" ondragstart="drag(event)" id="image3" style="height: inherit; width: 100%" class="img">');
                    }
                }
            }
            $('.totalCredits').val(value);
            console.log(value);
            }

            $("#adsForm").on('click', function () {
                if ($("#des").val() == " ") {
                    $(this).css('border', 'red');
                }
            });
            $("#adsForm").click(function () {
                $.validate();
            });


    </script>
@endsection
