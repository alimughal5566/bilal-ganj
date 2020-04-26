{{--MOdal--}}
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h6 class="modal-title" id="gridSystemModalLabel">Please set you Address here....</h6>
                <button type="button" class="close location_close pt-2" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <input class="keyword-input refrence_get form-control" placeholder="Enter Your Address" type="text" value="" id="autocomplete" onFocus="geolocate()">
            <div id="map" style="width: 100%; height: 450px;"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" data-dismiss="modal">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->