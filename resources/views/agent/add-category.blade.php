@extends('layout.agent-layout')

@section('title','Vendor Panel')

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/admin/css/chosen.css')}}">
@endsection

@section('content','Add Category')

@section('rightPane')
    <div class="col-sm-4 col-md-5 col-lg-5">
        <div class="login">
            <div class="login_form_container">
                <div class="account_login_form account_form">
                    <h4 class="mb-3"><i class="fas fa-plus-circle"></i> Category</h4>
                    <form class="needs-validation shadow p-5"
                          novalidate action="{{route('addCategory')}}" method="post">
                        @csrf
                        @if(Session()->has('saveCat'))
                            <div class="alert alert-success">
                                {{Session()->get('saveCat')}}
                            </div>
                        @endif
                        <h2 class="d-flex justify-content-center">Category Detail</h2>
                        <div class="form-row">
                            <div class="col-md-12 col-12">
                                <label>Category Name <span>*</span></label>
                                <input type="text"
                                       class="form-control mb-1" name="name" required>
                                @include('error.error', ['filed' => 'name'])
                                <div class="invalid-feedback">
                                    Product Name Required
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 col-12">
                                <label>Select Parent Category<span>*</span></label>
                                <select required name="parent_id" class="chosen-select">
                                    <option></option>
                                    @foreach($dropCats as $category)
                                        <option value="{{$category['id']}}">{{$category['name']}}</option>
                                    @endforeach
                                </select>
                                @include('error.error', ['filed' => 'parent_id'])
                                <div class="invalid-feedback">
                                    parent_id Required
                                </div>
                            </div>
                        </div>
                        <div class="form-row pt-4 ">
                            <div class="login_submit">
                                <button type="submit" class="btn btn-block btn-success ml-0">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('assets/admin/js/chosen.jquery.js')}}"></script>
    <script src="{{asset('assets/admin/js/init.js')}}"></script>
@endsection