@extends('layout.rider-layout')
@section('title','Tracking....')
@section('styles')
    <script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.19.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"/>
@endsection
@section('content','Tracking')
@section('rightPane')
    <div class="col-sm-12 col-md-9 col-lg-9">
        <div>
            <strong>Start Time: </strong><label id="dispatchTime">{{isset($ride->start_time)?$ride->start_time:''}}</label>
        </div>
        <div>
            <strong>End Time: </strong><label id="arivalTime">{{isset($ride->end_time)?$ride->end_time:''}}</label>
        </div>
        <div class="mb-3">
            <strong>Distance: </strong><label class="distance_field">{{isset($ride->distance)?$ride->distance:''}}</label>
        </div>
        <div class="tab-content dashboard_content">
            <div id="map-canvas" style="width:100%;height:400px"></div>
        </div>
        <div class="mt-3">
            <a href="{{route('rideCompleted',['id'=>$ride->order_id])}}">
                <button class="btn btn-primary">Arrived</button>
            </a>
        </div>
    </div>
    <input type="hidden" id="distance_field" value="{{isset($ride->distance)?$ride->distance:''}}">
    <input type="hidden" id="start_time" value="{{isset($ride->start_time)?$ride->start_time:''}}">
    <input type="hidden" id="end_time" value="{{isset($ride->end_time)?$ride->end_time:''}}">
    <input type="hidden" id="order-id" value="">
    <input type="hidden" id="time" value="{{$requiredTime}}">
    <input type="hidden" name="latitude" id="latitude"
           value="{{$ride->destination_latitude}}">
    <input type="hidden" name="longitude" id="longitude"
           value="{{$ride->destination_longitude}}">
    <input type="hidden" name="vendorLati" id="vendorLati"
           value="{{$ride->origin_latitude}}">
    <input type="hidden" name="vendorLongi" id="vendorLongi"
           value="{{$ride->origin_longitude}}">
    <input type="hidden" name="riderLati" class="riderLati"
           value="">
    <input type="hidden" name="riderLongi" class="riderLongi"
           value="">
    <input type="hidden" name="riderID" id="riderID"
           value="{{$ride->rider_id}}">
    <input type="hidden" name="orderID" id="orderID"
           value="{{$ride->order_id}}">
@endsection
@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqSTkzPn8PpJBY3Pclu-TTjmGDLzqKMD4&callback=check"
            async defer></script>
    <script>
        let strTime;
        let riderID;
        let orderID;
        let measureDistance;
        let endTime;
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

        navigator.geolocation.getCurrentPosition(function (position) {
            $('.riderLati').val(position.coords.latitude);
            $('.riderLongi').val(position.coords.longitude);
            if($('#distance_field').val() === ''){
                calculateDistance();;
            }
            if($('#start_time').val() === '' || $('#end_time').val() === '') {
                getTime();
            }
            check();
        });

        function calculateDistance() {
            var service = new google.maps.DistanceMatrixService();
            var user = new google.maps.LatLng(($('#latitude').val()), $('#longitude').val());
            var rider = new google.maps.LatLng(($('.riderLati').val()), $('.riderLongi').val());
            service.getDistanceMatrix(
                {
                    origins: [user],
                    destinations: [rider],
                    travelMode: 'DRIVING',
                }, callback);

            function callback(response, status) {
                if (status == 'OK') {
                    var origins = response.originAddresses;
                    var destinations = response.destinationAddresses;

                    for (var i = 0; i < origins.length; i++) {
                        var results = response.rows[i].elements;
                        for (var j = 0; j < results.length; j++) {
                            var element = results[j];
                            var distance = element.distance.text;
                            var duration = element.duration.text;
                            var from = origins[i];
                            var to = destinations[j];
                            console.log(distance);
                        }

                        $('.distance_field').html(distance);
                        $('#distance_field').val(distance);
                        measureDistance = $('#distance_field').val();
                        endTime = $('#end_time').val();

                        $.ajax({
                            url: SAVETIME,
                            method: 'get',
                            data: {time: strTime,arrivalTime: endTime,calDistance:measureDistance,rID: riderID,oID:orderID},
                            success: function (response) {
                                // alert(response);
                            },
                            error: function () {
                                // alert('failed');
                            }
                        });
                    }
                }
            }

        }

        function getTime() {
            var date = new Date();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            strTime = hours + ':' + minutes + ' ' + ampm;
            riderID = $('#riderID').val();
            orderID = $('#orderID').val();
            measureDistance = $('#distance_field').val();
            $('#dispatchTime').html(strTime);
            $('#start_time').val(strTime);
            var reqDate = new Date("1/1/1900 " + $('#time').val());
            var reqHours = reqDate.getHours();
            reqHours = parseInt(hours) + parseInt(reqHours);
            var reqMinutes = reqDate.getMinutes();
            reqMinutes = parseInt(minutes) + parseInt(reqMinutes);
            // var reqAmpm = reqHours >= 12 ? 'pm' : 'am';
            reqHours = reqHours % 12;
            reqHours = reqHours ? reqHours : 12; // the hour '0' should be '12'
            reqMinutes = reqMinutes < 10 ? '0' + reqMinutes : reqMinutes;
            var reqStrTime = reqHours + ':' + reqMinutes;
            $('#arivalTime').html(reqStrTime);
            $('#end_time').val(reqStrTime);

        }

        function check() {
            // calculateDistance();
            console.log('rider latitude ' + $('.riderLati').val());
            console.log('rider longitude ' + $('.riderLongi').val());

            window.lat = parseFloat($('.riderLati').val());
            window.lng = parseFloat($('.riderLongi').val());

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(updatePosition);
                    console.log('after upate curent lati' + window.lat);
                    console.log('after upate curent Longi' + window.lng);
                }
                return null;
            }

            function updatePosition(position) {
                if (position) {
                    window.lat = position.coords.latitude;
                    window.lng = position.coords.longitude;
                }
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
                zoom: 15,
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

                var request = {origin: riderLocation, destination: userLocation, travelMode: 'DRIVING'};

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
                $.ajax({
                    url: '/update-rider-location',
                    method: 'get',
                    data: {reqLati: lat, reqLng: lng, orderId: order_id},
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (error) {
                        // window.location.href = HOME;
                    }

                });

                if (mark != undefined) {

                } else {
                    mark = new google.maps.Marker({
                        position: {lat: lat, lng: lng},
                        map: map,
                    });
                    addMarker();

                }
                updatePosition(getLocation());
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

@endsection
