@extends('layouts.app')
@section('title', 'Not Authorized')
@section('content')
    <div class="container h-100">
        <div class="row py-5 h-100 text-center align-items-center justify-content-center">
            <div class="col-md-6">
                <div class="error-title ff-poppins text-icon-gold">401</div>
                <div class="h3">Not Authorized</div>
                <div class="text-muted">
                    You are not authorized to access this page
                </div>
            </div>
        </div>
    </div>
@endsection
