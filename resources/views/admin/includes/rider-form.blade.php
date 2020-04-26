<div class="form-row">

    <div class="col">
        <label>User Name</label>
        <input type="text" class="form-control" name="name" required
               value="{{isset($user)? $user->name :old('name')}}">
        @include('error.error', ['filed' => 'name'])
        <div class="invalid-feedback">
            Name Required
        </div>
    </div>
    <div class="col">
        <label>Email</label>
        <input type="email" class="form-control" name="email" required
               value="{{isset($user)? $user->email:old('email')}}">
        @include('error.error', ['filed' => 'email'])
        <div class="invalid-feedback">
            Valid Email Required
        </div>
    </div>
</div>
<div class="form-row">
    @if(isset($user))
        @php($type = $user->rider()->first()->vehicle_type)
    @endif
    <div class="col">
        <label>Vehicle Type</label>
        <select class="form-control vehicle_type" name="vehicle_type">
            <option value="bike" {{ isset($type) && $type=='bike'?'selected':'' }}>Bike</option>
            <option value="pickup" {{ isset($type) && $type =='pickup'?'selected':'' }}>Pickup</option>
            <option value="loadingRickshaw" {{ isset($type) && $type =='loadingRickshaw'?'selected':'' }}>Loading
                Rickshaw
            </option>
        </select>
    </div>

    <div class="col">
        <label>Vehicle Number</label>
        <input type="text" class="form-control" name="vehicle_number" required
               value="{{isset($user)? $user->rider()->first()->vehicle_number:old('vehicle_number')}}">
        @include('error.error', ['filed' => 'vehicle_number'])
        <div class="invalid-feedback">
            Vehicle Number is Required
        </div>
    </div>

    <div class="col">
        <label>Contact Number</label>
        <input type="number" class="form-control" name="contact_number" required
               value="{{isset($user)? $user->contact_number:old('contact_number')}}">
        @include('error.error', ['filed' => 'contact_number'])
        <div class="invalid-feedback">
            Valid Contact Number Required
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col">
        <label>Salary</label>
        <input type="number" class="form-control" name="salary" required
               value="{{isset($user)? $user->rider()->first()->salary : old('salary')}}">
        @include('error.error',['filed'=>'salary'])
        <div class="invalid-feedback">
            Salary required
        </div>
    </div>

    <div class="col">
        <label>Date of Join</label>
        <input id="datepicker" class="form-control" name="date_of_joining" required
               value="{{isset($user)? $user->rider()->first()->date_of_joining : old('date_of_joining')}}">
        @include('error.error',['filed'=>'date_of_joining'])
        <div class="invalid-feedback">
            Date of Join is required
        </div>
    </div>
</div>
<div class="form-row">
    <div><label>Address</label></div>
    <textarea rows="3" cols="68" id="refrence_set" value="" class="form-control location" data-toggle="modal"
              data-target="#myModal" name="address"
              required>{{isset($user)? $user->address:old('address')}}</textarea>
    <input type="hidden" value="{{isset($user)?$user->latitude: 31.5204}}" id="lati" name="latitude">
    <input type="hidden" value="{{isset($user)?$user->longitude: 74.3587}}" id="longi" name="longitude">
    @include('error.error', ['filed' => 'address'])
    <div class="invalid-feedback">
        Address Required
    </div>
</div>



