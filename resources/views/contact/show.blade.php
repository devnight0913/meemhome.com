@extends('layouts.app')
@section('title', 'Contact | ' . config('app.name'))
@section('header')

    <div id="pagetitle" class="bg-primary position-relative">
        <div id="particals"></div>
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="page-title-inner">
                <div class="image-overlay"></div>
                <div class="page-title-holder">
                    <div class="title-main">Contact</div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('content')
    <section class="py-5">

        <div class="row mb-3">
            <div class="col-md-6 mb-3 d-flex align-items-stretch">
                <div class="card w-100 border-0 rounded-4 bg-om-light">
                    <div class="card-body py-5 px-5">
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-phone fa-2xl text-primary"></i>
                        </div>
                        <div class="text-center h4 text-primary fw-bold">
                            Phone
                        </div>
                        <div class="text-center">
                            <a href="tel:{{ $phone }}" class="link-primary">
                                {{ $phone }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 d-flex align-items-stretch">
                <div class="card w-100 border-0 rounded-4 bg-om-light">
                    <div class="card-body py-5 px-5">
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-envelope fa-2xl text-primary"></i>
                        </div>
                        <div class="text-center h4 text-primary fw-bold">
                            Email
                        </div>
                        <div class="text-center">
                            <a href="mailto:{{ $email }}" class="link-primary">
                                {{ $email }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 
        <div class="row mb-3">
            <div class="col-md-4 mb-3 d-flex align-items-stretch">
                <div class="card w-100 border-0 rounded-4 bg-om-light">
                    <div class="card-body py-5 px-5">
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-phone fa-2xl text-primary"></i>
                        </div>
                        <div class="text-center h4 text-primary fw-bold">
                            Phone
                        </div>
                        <div class="text-center">
                            <a href="tel:{{ $phone }}" class="link-primary">
                                {{ $phone }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 d-flex align-items-stretch">
                <div class="card w-100 border-0 rounded-4 bg-om-light">
                    <div class="card-body py-5 px-5">
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-envelope fa-2xl text-primary"></i>
                        </div>
                        <div class="text-center h4 text-primary fw-bold">
                            Email
                        </div>
                        <div class="text-center">
                            <a href="mailto:{{ $email }}" class="link-primary">
                                {{ $email }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 d-flex align-items-stretch">
                <div class="card w-100 border-0 rounded-4 bg-om-light">
                    <div class="card-body py-5 px-5">
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-location-dot fa-2xl text-primary"></i>
                        </div>
                        <div class="text-center h4 text-primary fw-bold">
                            Location
                        </div>
                        <div class="text-center">
                            <a href="{{ $gm_share_link }}" class="link-primary">
                                {{ $address }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            {!! $gm_iframe !!}
        </div> --}}
        <section class="mb-3">
            <header class="mb-3 mt-3 ff-montserrat text-uppercase h3 text-center">Send a message</header>
            <contact-form-component></contact-form-component>
        </section>
    </section>

@endsection
@push('script')
    <script>
        particlesJS.load('particals', '/particles.json');
    </script>
@endpush
