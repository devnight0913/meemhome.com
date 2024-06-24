@extends('layouts.app')
@section('title', 'Internal Server Error!')
@section('content')
    <div class="container h-100">
        <div class="row py-5 h-100 text-center align-items-center justify-content-center">
            <div class="col-md-6">
                <div class="error-title ff-poppins text-icon-gold">500</div>
                <div class="h3">Oops! Internal Server Error!</div>
                <div class="text-muted">
                    The server encountered an unexpected condition that prevents it from fulfilling
                    the request.
                </div>
                <div class="text-muted">
                    Our developers have received a notification about the issue and everything will
                    be fixed soon.
                </div>
            </div>
        </div>
    </div>
@endsection
