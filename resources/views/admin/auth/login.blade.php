@extends('admin.auth.master')
@section('title', config('app.name') . ' Admin | Login')


@section('content')
    <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <div class=" text-center mb-3">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/webp/logo_with_name.webp') }}" style="max-width: 250px;"
                    alt="{{ config('app.name') }}">
            </a>
        </div>
        <div class="card shadow-sm border-primary rounded-3" style="background-color: rgba(255, 255, 255, .6">
            <div class="card-body py-5">

                <h5 class="card-title text-center text-primary fw-bold">Log in to the system</h5>
                <admin-login-component></admin-login-component>
            </div>
        </div>
        <div class="text-center py-2">
            <span class="text-muted">
                {{ config('app.name') }} © {{ date('Y') }}
            </span>
        </div>
    </div>
@endsection
