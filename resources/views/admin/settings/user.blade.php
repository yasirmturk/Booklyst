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
                            <a href="#" data-toggle="modal" data-target="#modal-add">Add New</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($users as $user)
                            <li class="list-group-item row">
                                <h5>{{ $user->name }}
                                    <small>{{ $user->email }}</small>
                                </h5>
                                <form action="{{ route('admin.settings.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
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
                    <h4 class="modal-title">Register new User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.settings.users.store') }}">
                    @csrf
                    <div class="modal-body">
                        <p>Enter the details&hellip;</p>
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="name" class="form-control" id="inputName" name="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <label for="inputPasswordC">Repeat Password</label>
                            <input type="password" class="form-control" id="inputPasswordC" name="password_confirmation" placeholder="Confirm password">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="submit" class="btn btn-primary">Save user</button>
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