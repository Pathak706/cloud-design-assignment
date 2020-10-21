@extends('layouts.app')

@section('content')

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" action="{{url('/category')}}" method="post">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" name="name" id="editname">
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
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteForm" action="{{url('/category')}}" method="post">
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
            <th scope="col">Category Name</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($category as $cat)
        <tr>
            <td scope="row" hidden="true">{{$cat->id}}</td>
            <td>{{$cat->name}}</td>
            <td>
                <button type="button" class="btn btn-warning editBtn" data-toggle="modal" data-catId="{{$cat->id}}"
                    data-catName="{{$cat->name}}" data-target="#editModal">Edit</button>
            </td>
            <td>
                <button type="button" class="btn btn-danger deleteBtn" data-toggle="modal" data-catId="{{$cat->id}}"
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

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addNewCategory" action="{{route('cateogry.create')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Category Name:</label>
                        <input type="text" class="form-control" name="name" id="name">
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
        $("#editForm").attr("action", `/category/${data[0]}`)
        $("#editname").val(data[1]);
    })
    $(".deleteBtn").on('click', function(event) {
        event.preventDefault();
        $('#deleteModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        $("#deleteForm").attr("action", `/category/${data[0]}`)
    })
});
</script>
@endsection