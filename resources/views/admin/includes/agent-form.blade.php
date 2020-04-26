<div class="form-row">

    <div class="col-md-6 col-12">
        <label>User Name <span>*</span></label>
        <input type="text" class="form-control" name="name" required
               value="{{isset($agentData)? $agentData->name :old('name')}}">
        @include('error.error', ['filed' => 'name'])
        <div class="invalid-feedback">
            Name Required
        </div>
    </div>
    <div class="col-md-6 col-12">
        <label>Email <span>*</span></label>
        <!--suppress HtmlFormInputWithoutLabel -->
        <input type="email" class="form-control" name="email" required
               value="{{isset($agentData)? $agentData->email:old('email')}}">
        @include('error.error', ['filed' => 'email'])
        <div class="invalid-feedback">
            Valid Email Required
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col">
        <label>Salary <span>*</span></label>
        <input type="number" class="form-control" name="salary" required
               value="{{isset($agentData)? $agentData->agent()->first()->salary : old('salary')}}">
        @include('error.error',['filed'=>'salary'])
        <div class="invalid-feedback">
            Salary required
        </div>
    </div>

    <div class="col">
        <label>Contact Number <span>*</span></label>
        <input type="number" class="form-control" name="contact_number" required
               value="{{isset($agentData)? $agentData->contact_number:old('contact_number')}}">
        @include('error.error', ['filed' => 'contact_number'])
        <div class="invalid-feedback">
            Valid Contact Number Required
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col">
        <label>Qualification <span>*</span></label>
        <input type="text" class="form-control" name="qualification" required
               value="{{isset($agentData)? $agentData->agent()->first()->qualification :old('qualification')}}">
        @include('error.error',['filed'=>'qualification'])
        <div class="invalid-feedback">
            Qualification required
        </div>
    </div>

    <div class="col">
        <label>Date of Join<span>*</span></label>
        <input id="datepicker" class="form-control" name="date_of_joining" required
               value="{{isset($agentData)? $agentData->agent()->first()->date_of_joining : old('date_of_joining')}}">
        @include('error.error',['filed'=>'date_of_joining'])
        <div class="invalid-feedback">
            Date of Join of required
        </div>
    </div>
</div>
<div class="form-row">
    <div><label>Address<span>*</span></label></div>
    <textarea rows="3" cols="68" id="refrence_set" value="" class="form-control location" data-toggle="modal"
              data-target="#myModal" name="address"
              required>{{isset($agentData)? $agentData->address:old('address')}}</textarea>
    <input type="hidden" value="{{isset($agentData)?$agentData->latitude: 31.5204}}" id="lati" name="latitude">
    <input type="hidden" value="{{isset($agentData)?$agentData->longitude: 74.3587}}" id="longi" name="longitude">
    @include('error.error', ['filed' => 'address'])
    <div class="invalid-feedback">
        Address Required
    </div>
</div>
