@extends('layouts.app')
@section('title', 'Access Denied!')

@section('content')
    <div class="container h-100">
        <div class="row py-5 h-100 text-center align-items-center justify-content-center">
            <div class="col-md-6">
                <div class="error-title ff-poppins text-icon-gold">403</div>
                <div class="h3">Access Denied!</div>
                <div class="text-muted">
                    Unfortunately, you do not have permission to view this page.
                </div>
            </div>
        </div>
    </div>
@endsection
