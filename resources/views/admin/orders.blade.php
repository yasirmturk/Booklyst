@extends('admin.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <ul class="list-group list-group-flush">
                @foreach($orders as $order)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2">
                            <img class="img-thumbnail rounded w-100" style="object-fit: cover;" src="{{ asset('images/vendor/admin-lte/dist/AdminLTELogo.png') }}" />
                        </div>
                        <div class="col">
                            <h5>{{ $order->amount }}
                                <small><i class="fas fa-piggy-bank"></i> € {{ $order->amount }}<del></del></small>
                                <span class="badge bg-black"><i class="fas fa-pound-sign"></i> {{ $order->amount }}</span>
                            </h5>
                            <p>
                                <a class="btn btn-app">
                                    <i class="fas fa-stopwatch"></i> {{ $order->amount }} minute(s)
                                </a>
                                <a class="btn btn-app">
                                    <span class="badge bg-teal">99+</span>
                                    <i class="fas fa-calendar-check"></i> Bookings
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
