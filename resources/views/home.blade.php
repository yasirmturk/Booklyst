@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    <example-component></example-component>
                    <!-- list of clients people have authorized to access our account -->
                    <passport-authorized-clients></passport-authorized-clients>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
