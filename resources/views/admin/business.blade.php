@extends('admin.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <ul class="list-group list-group-flush">
                @foreach($businesses as $business)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2">
                            <img class="img-thumbnail rounded w-100" style="object-fit: cover; height: 200px;" src="{{ $business->dp('/images/s/') ?? asset('images/vendor/admin-lte/dist/AdminLTELogo.png') }}" />
                        </div>
                        <div class="col-6">
                            <h5>{{ $business->name }}
                                @if ($business->is_service) <span class="badge badge-info"><i class="fa fa-check"></i>
                                    Service
                                </span> @endif
                                @if ($business->is_product) <span class="badge badge-info"><i class="fa fa-check"></i>
                                    Product
                                </span> @endif
                                </small>
                            </h5>
                        </div>
                        <form action="{{ route('admin.businesses.destroy', $business->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="close" aria-label="Delete"><span aria-hidden="true">&times;</span></button>
                        </form>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
