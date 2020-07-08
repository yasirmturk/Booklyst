@extends('admin.layouts.app')
@section('content')
<!-- Main content -->
<div class="content">
    Category
    @foreach ($categories as $category)
    <p>This is user {{ $category->name }}</p>
    @endforeach
</div>
<!-- /.content -->
@endsection
