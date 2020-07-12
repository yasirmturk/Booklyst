@extends('admin.layouts.app')
@section('content')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @php
                //
                @endphp
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Category</h3>
                        <div class="card-tools">
                            <a href="#" data-toggle="modal" data-target="#modal-add">Add New</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($categories as $category)
                            <li class="list-group-item row">
                                <h5 class="col-6">{{ $category->name }}
                                    <small>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="checkboxService" disabled {{ $category->is_service ? 'checked':'' }}>
                                            <label for="checkboxServices">Service</label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="checkboxProduct" disabled {{ $category->is_product ? 'checked':'' }}>
                                            <label for="checkboxProduct">Product</label>
                                        </div>
                                    </small>
                                </h5>
                                <div class="col-1">
                                    <form action="{{ route('admin.settings.categories.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add new Business Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.settings.categories.store') }}">
                    @csrf
                    <div class="modal-body">
                        <p>Enter the details&hellip;</p>
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="name" class="form-control" id="inputName" name="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="inputService" name="is_service">
                                <label for="inputService">
                                    Service
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="inputProduct" name="is_product">
                                <label for="inputProduct">
                                    Product
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <!-- <button type="cancel" class="btn btn-default" data-dismiss="modal">Close</button> -->
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
<!-- /.content -->
@endsection
