@extends('admin.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <ul class="list-group list-group-flush">
                @foreach($services as $service)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            {{ $service->name }}
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
