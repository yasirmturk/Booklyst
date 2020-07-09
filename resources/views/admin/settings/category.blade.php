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
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @foreach ($categories as $category)
                        <div class="form-group clearfix">
                            <strong>{{ $category->name }}</strong>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxService" {{ $category->is_service ? 'checked':'' }}>
                                <label for="checkboxServices">
                                    Service
                                </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxProduct" {{ $category->is_product ? 'checked':'' }}>
                                <label for="checkboxProduct">
                                    Product
                                </label>
                            </div>
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
</div>
<!-- /.content -->
@endsection