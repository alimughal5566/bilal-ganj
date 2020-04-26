<div class="col-sm-12 col-md-9 col-lg-9">
    <div class="tab-content dashboard_content">
        <div id="map" class="w-100 track-map"></div>
    </div>
</div>
<input type="hidden" name="latitude" id="latitude"
       value="{{$ride->destination_latitude}}">
<input type="hidden" name="longitude" id="longitude"
       value="{{$ride->destination_longitude}}">
<input type="hidden" name="vendorLati" id="vendorLati"
       value="{{$ride->origin_latitude}}">
<input type="hidden" name="vendorLongi" id="vendorLongi"
       value="{{$ride->origin_longitude}}">
<input type="hidden" name="riderLati" id="riderLati"
       value="{{$ride->rider_latitude}}">
<input type="hidden" name="riderLongi" id="riderLongi"
       value="{{$ride->rider_longitude}}">

