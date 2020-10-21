@extends('layouts.app')

@section('content')

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" action="{{url('/product')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editname" class="col-form-label">Product Name:</label>
                        <input type="text" class="form-control" name="name" id="editname" required>
                    </div>
                    <div class="form-group">
                        <label for="editcategory" class="col-form-label">Category Name:</label>
                        <!-- <input type="text" class="form-control" name="category" id="category"> -->
                        <select name='category' id='editcategory' class='form-control' required>
                            <option value="">Select Category</option>
                            @foreach($category as $cat)
                            <option value='{{$cat->id}}'>{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editqty" class="col-form-label">Product Quantity:</label>
                        <input type="number" class="form-control" name="qty" id="editqty" required>
                    </div>
                    <div class="form-group">
                        <label for="editprice" class="col-form-label">Product Price:</label>
                        <input type="number" class="form-control" name="price" id="editprice" required>
                    </div>
                    <div class="form-group">
                        <label for="editimage_uri" class="col-form-label">Product Photo:</label>
                        <input type="file" class="form-control" name="image_uri" id="editimage_uri" accept="image/*">
                    </div>
                    <div class="form-group">
                        <img src="#" id="productPreview" alt="product image preview">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteForm" action="{{url('/product')}}" method="post">
                @csrf
                @method('delete')
                <div class="modal-body">
                    Are You Sure ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- List Data -->
<table class="table">
    <thead>
        <tr>
            <th scope="col" hidden="true">ID</th>
            <th scope="col">Product Name</th>
            <th scope="col">Category Name</th>
            <th scope="col">Qty</th>
            <th scope="col">Price</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($product as $pro)
        <tr>
            <td scope="row" hidden="true">{{$pro->id}}</td>
            <td>{{$pro->name}}</td>
            <td>{{$pro->categoryRel->name}}</td>
            <td>{{$pro->qty}}</td>
            <td>{{$pro->price}}</td>
            <td>
                <button type="button" class="btn btn-warning editBtn" data-toggle="modal"
                    data-proImg="{{$pro->image_uri}}" data-catId="{{$pro->categoryRel->id}}"
                    data-target="#editModal">Edit</button>
            </td>
            <td>
                <button type="button" class="btn btn-danger deleteBtn" data-toggle="modal" data-proId="{{$pro->id}}"
                    data-target="#deleteModal">
                    Delete
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('addForm')
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add New</button>

<!-- discrete product vs duplicate product vs all -->
<form action="{{route('product.index')}}" method="get"
    style="margin-left: 2em; display: flex; justify-content: space-between; width:20em;">
    @csrf
    <div class="form-check">
        <input class="form-check-input" type="radio" name="filter" id="all" value="all" 
        {{ ($filter == "all") || isset($filter) ? "checked" : "" }} onclick="this.form.submit()">
        <label class="form-check-label" for="all">
           ALL
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="filter" id="duplicate" value="duplicate"
            {{ ($filter == "duplicate") ? "checked" : "" }} onclick="this.form.submit()">
        <label class="form-check-label" for="duplicate">
            Duplicate
        </label>
    </div>
</form>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addNewProduct" action="{{route('product.create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Product Name:</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-form-label">Category Name:</label>
                        <!-- <input type="text" class="form-control" name="category" id="category"> -->
                        <select name='category' id='category' class='form-control' required>
                            <option value="">Select Category</option>
                            @foreach($category as $cat)
                            <option value='{{$cat->id}}'>{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qty" class="col-form-label">Product Quantity:</label>
                        <input type="number" class="form-control" name="qty" id="qty" required>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-form-label">Product Price:</label>
                        <input type="number" class="form-control" name="price" id="price" required>
                    </div>
                    <div class="form-group">
                        <label for="image_uri" class="col-form-label">Product Photo:</label>
                        <input type="file" class="form-control" name="image_uri" id="image_uri" accept="image/*"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $(".editBtn").on('click', function(event) {
        event.preventDefault();
        $('#editModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        $("#editForm").attr("action", `/product/${data[0]}`)
        $("#editname").val(data[1]);
        $('#editcategory option[value="' + $(this).attr("data-catId") + '"]').prop('selected',
            'selected')
        $("#editqty").val(data[3]);
        $("#editprice").val(data[4]);
        $("#productPreview").attr('src', "/uploads/" + $(this).attr("data-proImg"));
        $("#productPreview").css('height', '3em');
    })
    $(".deleteBtn").on('click', function(event) {
        event.preventDefault();
        $('#deleteModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        $("#deleteForm").attr("action", `/product/${data[0]}`)
    })
});
</script>
@endsection