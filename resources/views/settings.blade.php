@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col">
        <div class="card">
            <div class="card-header">Start setting up your amazing business online!</div>
            <div class="card-body row">
                <div class="col-3">
                    <div class="list-group list-group-flush" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action" data-toggle="list" role="tab" href="#tab-Content" id="tab-business">Business details</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" role="tab" href="#tab-Content" id="tab-address">Address & location</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" role="tab" href="#tab-Content" id="tab-schedule">Schedule</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" role="tab" href="#tab-Content" id="tab-services">Services</a>
                        <a class="list-group-item list-group-item-action active" data-toggle="list" role="tab" href="#tab-bankContent" id="tab-bank">Bank accounts</a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade" role="tabpanel" id="tab-Content" aria-labelledby="tab-services">...</div>
                        @include('components.bank', ['bankAccount' => $bankAccount ])
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection
