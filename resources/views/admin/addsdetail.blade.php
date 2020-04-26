@extends('layout.backend-layout')
@section('title','Admin - Add Packages')

@section('content')
    <div class="container mt-4">
                <!--register area start-->
                    <div class="account_form register ml-5 ">
                        @if(Session()->has('success'))
                            <div class="alert alert-success">
                                {{session()->get('success')}}
                            </div>
                        @endif
                        <form action="{{route('saveAdDetail')}}" method="post" class="needs-validation shadow p-5 w-75 ml-5"
                              novalidate>
                            @csrf
                            @if($message = Session::get('saveAdDetail'))
                                <div class="alert alert-success">{{$message}}</div>
                            @endif
                            <h2 class="d-flex justify-content-center">Advertisements & Details</h2>
                            <div class="form-row m-3">
                                <div class="col">
                                        <label>Select Type<span>*</span></label>
                                        <select data-placeholder="please select" name="type" class="form-control"
                                                required>
                                            <option value="Banner">Top banner</option>
                                            <option value="Top-Right-Slot">Top Right Slot</option>
                                            <option value="Right-bottom-Slot">Right bottom Slot</option>
                                        </select>
                                        @include('error.error', ['filed' => 'type'])
                                        <div class="invalid-feedback">
                                            Type Required
                                        </div>
                                </div>
                                <div class="col">
                                    <i class="fas fa-calendar-alt"></i>
                                    <label>Minimum Duration in Days</label>
                                    <input type="number" class="form-control" required min="1"  name="duration" value="{{old('duration')}}">
                                    @include('error.error',['filed'=>'duration'])
                                    <div class="invalid-feedback">
                                        Minimum Duration required
                                    </div>
                                </div>
                            </div>
                            <div class="form-row m-3">
                                <div class="col">
                                    <i class="fas fa-money-bill-wave-alt"></i> Total credit Points per day
                                    <input class="form-control" type="number" min="1" name="credits" required value="{{old('credits')}}">
                                    @include('error.error',['filed'=>'credits'])
                                    <div class="invalid-feedback">
                                        credit required
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="mb-0">Size<span>*</span></label>
                                    <select data-placeholder="select size" name="size" class="form-control"
                                            required>
                                        <option value="Top">Large</option>
                                        <option value="Right">Medium</option>
                                        <option value="Bottom">Small</option>
                                    </select>
                                    @include('error.error', ['filed' => 'size'])
                                    <div class="invalid-feedback">
                                        Size Required
                                    </div>
                                </div>
                            </div>
                            <div class="form-row pt-3 d-flex justify-content-center">
                                <div class="login_submit">
                                    <button type="submit" class="btn btn-block btn-primary login_submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                <!--register area end-->
            </div>
@endsection