@extends('errors.master')
@section('title', '503 Maintenance')
@section('content')
    <div class="error-title ff-poppins text-icon-gold">503</div>
    <h3>Maintenance.</h3>
    <div class="text-muted mb-3">
        We Will Be Back Soon
    </div>
    <div class="mb-3">
        @include('layouts.social-buttons')
    </div>
    <div>
        <x-logo /> © {{ date('Y') }}
    </div>
@endsection
