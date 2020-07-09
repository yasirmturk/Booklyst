@extends('admin.layouts.app')
@section('content')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Category</h3>
                        <div class="card-tools">
                            <a href="#" data-toggle="modal" data-target="#modal-lg">Add New</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @foreach ($categories as $category)
                        <h4>{{ $category->name }}</h4>
                        <div class="col-4">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxService" disabled {{ $category->is_service ? 'checked':'' }}>
                                <label for="checkboxServices">
                                    Service
                                </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxProduct" disabled {{ $category->is_product ? 'checked':'' }}>
                                <label for="checkboxProduct">
                                    Product
                                </label>
                            </div>
                            <button type="button" class="btn btn-block btn-danger">Delete</button>
                        </div>
                        @endforeach
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

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add new Business Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input type="name" class="form-control" id="inputName" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="inputService">
                            <label for="inputService">
                                Service
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="inputProduct">
                            <label for="inputProduct">
                                Product
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
<!-- /.content -->
@endsection
