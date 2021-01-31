@extends('admin.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <ul class="list-group list-group-flush">
                @foreach($bookings as $booking)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2">
                            <img class="img-thumbnail rounded w-100" style="object-fit: cover;" src="{{ $booking->service->business->dp('/images/s/') ?? asset('images/vendor/admin-lte/dist/AdminLTELogo.png') }}" />
                        </div>
                        <div class="col">
                            <h5>{{ $booking->service->name }}
                                <span class="badge bg-black"><i class="fas fa-pound-sign"></i> {{ $booking->amount }}</span>
                            </h5>
                            <p>
                                <a class="btn btn-app">
                                    <i class="fas fa-stopwatch"></i> {{ $booking->service_time->diffForHumans() }}
                                </a>
                                <a class="btn btn-app">
                                    <i class="fas fa-info-circle"></i> {{ $booking->status }}
                                </a>
                            </p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
