@extends('layouts.app')
@section('title', '404 Not Found')

@section('content')
    <div class="container h-100">
        <div class="row py-5 h-100 text-center align-items-center justify-content-center">
            <div class="col-md-6">
                <div class="error-title ff-poppins text-icon-gold">404</div>
                <div class="h3">Page Not Found</div>
                <div class="text-muted">
                    The page you are looking for might have been removed had its name changed or is
                    temporarily unavailable.
                </div>
            </div>
        </div>
    </div>
@endsection
