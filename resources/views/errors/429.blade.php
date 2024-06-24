@extends('layouts.app')
@section('title', 'Too Many Requests')
@section('content')
    <div class="container h-100">
        <div class="row py-5 h-100 text-center align-items-center justify-content-center">
            <div class="col-md-6">
                <div class="error-title ff-poppins text-icon-gold">429</div>
                <div class="h3">Too Many Requests</div>
            </div>
        </div>
    </div>
@endsection
