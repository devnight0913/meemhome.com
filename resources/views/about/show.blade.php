@extends('layouts.app')
@section('title', 'About Us | ' . config('app.name'))
@section('header')
    <div id="pagetitle" class="bg-primary position-relative">
        <div id="particals"></div>
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="page-title-inner">
                <div class="image-overlay"></div>
                <div class="page-title-holder">
                    <div class="title-main">About</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="mb-3 py-3">
        {!! $about !!}
    </div>
@endsection
@push('script')
    <script>
        particlesJS.load('particals', '/particles.json');
    </script>
@endpush
