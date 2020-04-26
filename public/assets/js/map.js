function initialize() {
    initMap();
    initAutocomplete();
}

var autocomplete , map;
var marker;

function initMap() {
    var pointA = new google.maps.LatLng($('#lati').val(), $('#longi').val());
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: pointA
    });
    var lati = $('#lati').val();
    var longi = $('#longi').val();
    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: pointA
    });
    google.maps.event.addListener(marker, 'dragend', function (event) {
        document.getElementById("lati").value = this.getPosition().lat();
        document.getElementById("longi").value = this.getPosition().lng();
        var check = marker.getPosition();
// alert(check.formatted_address);
        var geocoder = new google.maps.Geocoder(); // create a geocoder object
        var location = new google.maps.LatLng(this.getPosition().lat(), this.getPosition().lng()); // turn coordinates into an object
        geocoder.geocode({'latLng': location}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) { // if geocode success
                var add = results[0].formatted_address; // if address found, pass to processing function
                $('.refrence_get').val(add);
                $('#refrence_set').val(add);
            }
        });
    });
}

function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('autocomplete'), {types: ['geocode']});
    var place = autocomplete.getPlace();

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        marker.setMap(null);
        var place = autocomplete.getPlace();
        map.panTo(place.geometry.location);
        map.setZoom(15);
        $('#lati').val(place.geometry.location.lat());
        $('#longi').val(place.geometry.location.lng());
        $('#refrence_set').val($('.refrence_get').val());
        initMap();
    });
}

$('.save_map').click(function () {
    document.getElementById("lati").value = marker.getPosition().lat();
    document.getElementById("longi").value = marker.getPosition().lng();
});

$('#ref_id');
$('#refrence_set').click(function () {
    $('.refrence_get').val($('#refrence_set').val());
});
$('.refrence_get').keyup(function () {
    $('#refrence_set').val($('.refrence_get').val());
});


$(document).on('click', '.remark_submit', function () {
    navigator.geolocation.getCurrentPosition(function (position) {
        $('.geo_lati').val(position.coords.latitude);
        $('.geo_longi').val(position.coords.longitude);
        $('.remarks-form').submit();
    });
});

function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle(
                {center: geolocation, radius: position.coords.accuracy});
            autocomplete.setBounds(circle.getBounds());
        });
    }
}



function init() {
    var location = new google.maps.LatLng($('#latitude').val(), $('#longitude').val());
    var location2 = new google.maps.LatLng($('#vendorLati').val(), $('#vendorLongi').val());
    var locations = [
        ['Agent', location],
        ['Vendor', location2],
    ];
    console.log(locations);
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
    });
    for (var i = 0; i < locations.length; i++) {
        var item = locations[i];
        var marker = new google.maps.Marker({
            position: item[1],
            map: map,
            label: {
                fontWeight: 'bold',
                text: item[0],
                color: '#000',
            },
            icon: {
                labelOrigin: new google.maps.Point(11, 50),
                url: 'default_marker.png',
                size: new google.maps.Size(22, 40),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(11, 40),
            },
        });
    }
    var geocoder = new google.maps.Geocoder;
    var infowindow = new google.maps.InfoWindow;
    remarksAddress(geocoder, map, infowindow);

}

function calcDistance() {
    var service = new google.maps.DistanceMatrixService();
    var agent = new google.maps.LatLng(($('#latitude').val()), $('#longitude').val());
    var vendor = new google.maps.LatLng(($('#vendorLati').val()), $('#vendorLongi').val());
    service.getDistanceMatrix(
        {
            origins: [agent],
            destinations: [vendor],
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

                $('.distance_field').val(distance);
            }
        }
    }

}


function remarksAddress(geocoder, map, infowindow) {
    var directionsDisplay = new google.maps.DirectionsRenderer();
    var directionsService = new google.maps.DirectionsService();

    var agent = new google.maps.LatLng(parseFloat($('#latitude').val()), $('#longitude').val());
    var vendor = new google.maps.LatLng(parseFloat($('#vendorLati').val()), $('#vendorLongi').val());
    directionsDisplay.setMap(map);

    var request = {origin: vendor, destination: agent, travelMode: 'DRIVING'};

    directionsService.route(request, function (result, status) {
        if (status === 'OK') {
            directionsDisplay.setDirections(result);
            console.log(result, status);
        }
    });

    $('.distance_cal').on('click', function () {
        calcDistance();
    });

// function calcDistance() {
// var service = new google.maps.DistanceMatrixService();
// var agent = new google.maps.LatLng(($('#latitude').val()), $('#longitude').val());
// var vendor = new google.maps.LatLng(($('#vendorLati').val()), $('#vendorLongi').val());
// service.getDistanceMatrix(
// {
// origins: [agent],
// destinations: [vendor],
// travelMode: 'DRIVING',
// }, callback);
//
// function callback(response, status) {
// if (status == 'OK') {
// var origins = response.originAddresses;
// var destinations = response.destinationAddresses;
//
// for (var i = 0; i < origins.length; i++) {
// var results = response.rows[i].elements;
// for (var j = 0; j < results.length; j++) {
// var element = results[j];
// var distance = element.distance.text;
// var duration = element.duration.text;
// var from = origins[i];
// var to = destinations[j];
// console.log(distance);
// }
//
// $('.distance_field').val(distance);
// }
// }
// }
//
// }
}

function showTrack(geocoder, map, infowindow) {
    var directionsDisplay = new google.maps.DirectionsRenderer();
    var directionsService = new google.maps.DirectionsService();

    var userLocation = new google.maps.LatLng($('#latitude').val(), $('#longitude').val());
    var riderLocation = new google.maps.LatLng($('#riderLati').val(), $('#riderLongi').val());
    directionsDisplay.setMap(map);

    var request = {origin: riderLocation, destination: userLocation, travelMode: 'DRIVING'};

    directionsService.route(request, function (result, status) {
        if (status === 'OK') {
            directionsDisplay.setDirections(result);
        }
    });
}

function track() {
    var userLocation = new google.maps.LatLng($('#latitude').val(), $('#longitude').val());
    var riderLocation = new google.maps.LatLng($('#riderLati').val(), $('#riderLongi').val());
    var locations = [
        ['Customer', userLocation],
        ['Rider', riderLocation],
    ];
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
    });
    for (var i = 0; i < locations.length; i++) {
        var item = locations[i];
        var marker = new google.maps.Marker({
            position: item[1],
            map: map,
            label: {
                fontWeight: 'bold',
                text: item[0],
                color: '#000',
            },
            icon: {
                labelOrigin: new google.maps.Point(11, 50),
                url: 'default_marker.png',
                size: new google.maps.Size(22, 40),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(11, 40),
            },
        });
    }
    var geocoder = new google.maps.Geocoder;
    var infowindow = new google.maps.InfoWindow;
    showTrack(geocoder, map, infowindow);

}