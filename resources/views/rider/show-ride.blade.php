@extends('layout.frontend-layout')
@section('title','Tracking....')
@section('styles')
    <script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.19.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"/>
@endsection
@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{route('index')}}">home</a></li>
                            <li><a href="{{route('userAccount')}}">my account</a></li>
                            <li>Map View</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <section class="main_content_area">
        <div class="container">
            <div class="account_dashboard">
                <div class="col-md-12">
                    <div class="tab-content dashboard_content">
                        <div id="map-canvas" style="width:100%;height:400px"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="order-id" value="{{$ride->order_id}}">

    <input type="hidden" name="latitude" id="latitude"
           value="{{$ride->destination_latitude}}">
    <input type="hidden" name="longitude" id="longitude"
           value="{{$ride->destination_longitude}}">
    <input type="hidden" name="vendorLati" id="vendorLati"
           value="{{$ride->origin_latitude}}">
    <input type="hidden" name="vendorLongi" id="vendorLongi"
           value="{{$ride->origin_longitude}}">
    <input type="hidden" name="riderLati" class="riderLati"
           value="{{$ride->rider_latitude}}">
    <input type="hidden" name="riderLongi" class="riderLongi"
           value="{{$ride->rider_longitude}}">
@endsection
@section('scripts')
    <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });


        function check() {
            console.log('rider latitude ' + $('.riderLati').val());
            console.log('rider longitude ' + $('.riderLongi').val());

            window.lat = parseFloat($('.riderLati').val());
            window.lng = parseFloat($('.riderLongi').val());

            function getLocation() {
                $.ajax({
                    url: '/get-location',
                    method: 'get',
                    data: {orderId: order_id},
                    success: function (data) {
                        console.log(data);
                        window.lat = data.riderLat;
                        window.lng = data.riderLng;
                    },
                    error: function (error) {
                        console.log(error)
                    }

                });
            }

            var map;
            var userMark;
            var mark;
            var lineCoords = [];
            var userLocation = new google.maps.LatLng($('#latitude').val(), $('#longitude').val());
            var riderLocation = new google.maps.LatLng(lat, lng);
            var iconBase = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/';

            map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: {lat: lat, lng: lng},
                zoom: 12
            });
            console.log('user lati' + $('#latitude').val());
            console.log('user lati' + $('#longitude').val());
            userMark = new google.maps.Marker({
                position: userLocation,
                map: map,
            });

            mark = new google.maps.Marker({
                position: {lat: lat, lng: lng},
                map: map,
            });


            function addMarker() {
                var geocoder = new google.maps.Geocoder;
                var infowindow = new google.maps.InfoWindow;
                var directionsDisplay = new google.maps.DirectionsRenderer();
                var directionsService = new google.maps.DirectionsService();

                directionsDisplay.setMap(map);
                directionsDisplay.setOptions({suppressMarkers: true});

                var request = {origin: userLocation, destination: riderLocation, travelMode: 'DRIVING'};

                directionsService.route(request, function (result, status) {
                    if (status === 'OK') {
                        directionsDisplay.setDirections(result);
                    }
                });
            }

            order_id = $('#order-id').val();

            addMarker();
            setInterval(function () {
                console.log('update lati' + window.lat);
                console.log('update longi' + window.lng);
                console.log('map lati' + lat);
                console.log('map long' + lng);

                if (mark != undefined) {

                } else {
                    mark = new google.maps.Marker({
                        position: {lat: lat, lng: lng},
                        map: map,
                    });
                    addMarker();

                }
                getLocation();
            }, 1000);

            function currentLocation() {
                return {lat: window.lat, lng: window.lng};
            }

            var redraw = function (payload) {
                lat = payload.message.lat;
                lng = payload.message.lng;
                map.setCenter({lat: $('.riderLati').val(), lng: $('.riderLongi').val(), alt: 0});
                mark.setPosition({lat: lat, lng: lng, alt: 0});

                lineCoords.push(new google.maps.LatLng(lat, lng));

                var lineCoordinatesPath = new google.maps.Polyline({
                    path: lineCoords,
                    geodesic: true,
                    strokeColor: '#2E10FF'
                });

                lineCoordinatesPath.setMap(map);
            };
            var pnChannel = "map3-channel";

            var pubnub = new PubNub({
                publishKey: 'pub-c-669fe3c7-5132-4ff6-9daa-7f5e77d8b986',
                subscribeKey: 'sub-c-3301244a-a95f-11e9-b39e-aa7241355c4e'
            });

            pubnub.subscribe({channels: [pnChannel]});
            pubnub.addListener({message: redraw});
            setInterval(function () {
                pubnub.publish({channel: pnChannel, message: {lat: window.lat, lng: window.lng}});
            }, 500);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqSTkzPn8PpJBY3Pclu-TTjmGDLzqKMD4&callback=check"
            async defer></script>
@endsection
