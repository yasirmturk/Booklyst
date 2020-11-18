@extends('admin.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <ul class="list-group list-group-flush">
                @foreach($products as $product)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            {{ $product->name }}
                            <a class="btn btn-app">
                                <span class="badge bg-teal">67</span>
                                <i class="fas fa-inbox"></i> Orders
                            </a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
