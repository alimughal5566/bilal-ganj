@extends('layout.backend-layout')

@section('title','Admin - Dashboard')

@section('content')

<div id="content-wrapper">

    <div class="container-fluid">
        @if($message = Session::get('success'))
            <div class="alert alert-success mb-3">
                {{$message}}
            </div>
        @endif
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    <b>Product List</b>
                </div>
                <div class="card-body">

                    <div id="no-more-tables">
                        <table class="table table-responsive table-bordered text-center" id="dataTable" width="100%"
                               cellspacing="0">
                            <thead class="bg-grey">
                            <tr class="no_wrap">
                                <th>Product ID</th>
                                <th>Posted By</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Is visible</th>
                                <th>Quantity</th>
                                <th>Unit Cost Price</th>
                                <th>Image</th>
                                <th>Model</th>
                                <th>Discount</th>
                                <th>Is Feature</th>
                                <th>Posted Date</th>
                                <th>In Stock</th>
                                <th>Comments</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                @php
                                    $id = $product->bgshop_id;
                                    $vendor = \App\Models\BgShop::find($id);
                                    $user = $vendor->user()->first();
                                    $postedBy = $user['name'];
                                    $medias = $product->media()->get();
                                    $count = $product->media()->count();
                                    $countComment = $product->feedbacks()->count();
                                @endphp
                            <tr class="no_wrap">
                                <td data-title="Product ID">{{$product['id']}}</td>
                                <td data-title="Posted By">{{$postedBy}}</td>
                                <td data-title="Name">{{$product['name']}}</td>
                                <td data-title="Description">
                                    <div data-toggle="modal" data-target="#basicExampleModal">
                                        <input type="hidden" name="description" value="{{$product['description']}}">
                                        <i class="btn fa fa-eye view_description"></i>
                                    </div>
                                </td>
                                <td>{{$product->is_visible === 1?'Yes':'No'}}</td>
                                <td data-title="Quantity">{{$product['quantity']}}</td>
                                <td data-title="Unit Cost Price">{{$product['ucp']}}</td>
                                <td data-title="Image">
                                    <div data-toggle="modal" data-target="#MyPopup">
                                        <input type="hidden" name="count" value="{{$count}}">
                                        @php
                                        for($i =0; $i<$count; $i++){
                                            $path = asset('assets/images/'.$medias[$i]->image);
                                            echo "<input type='hidden' name='image$i' value='$path'>";
                                        }
                                        @endphp
                                        <i class="btn fa fa-eye view_image"></i>
                                    </div>
                                </td>
                                <td data-title="Model">{{$product['model']}}</td>
                                <td data-title="Discount">{{$product['discount']}}</td>
                                <td data-title="Is Feature">{{$product['is_feature']}}</td>
                                <td data-title="Posted Date">{{$product['created_at'] = date('Y-m-d')}}</td>
                                <td data-title="In Stock">{{$product['in_stock']}}</td>
                                <td data-title="Comments">
                                    {{$countComment}} Comment{{($countComment)>1 ? 's':''}}
                                    <br>
                                    <form method="get" class="view_post_comments"
                                          action="{{route('commentOnProduct')}}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product['id']}}">
                                        @if($product['deleted_at']== null)
                                            <i class="fas fa-external-link-alt view_comments cursor_pointer"></i>
                                        @endif
                                    </form>
                                </td>
                                <td data-title="Action">
                                    <a onclick="return confirm('Do you {{$product['deleted_at']!= null ? 'want to restore Product?':'really want to remove Product from Portal?'}}')"
                                       href="{{route($product['deleted_at']!= null ?'undoProduct':'deleteProduct',$product['id'])}}"><i
                                                class="fa {{$product['deleted_at']!= null ? 'fa-redo':'fa-trash'}} text-danger block_rider"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <!-- Modal -->
                            <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title" id="exampleModalLabel">Description</h5>
                                            <button type="button" class="close des_close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Popup -->
                            <div id="MyPopup" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">
                                                Images
                                            </h4>
                                            <button type="button" class="close" data-dismiss="modal">
                                                &times;</button>
                                        </div>
                                        <div class="text-center image_modal">
                                            <a class="btnShowPopup">

                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">Last Updated
                    at {{$time->updated_at->format('d M, Y h:i A')}}</div>
            </div>
        </div>
    </div>
</div>
@endsection
