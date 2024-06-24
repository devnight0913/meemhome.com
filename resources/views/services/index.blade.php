@extends('layouts.app')
@section('title', 'Services | ' . config('app.name'))
@section('header')
    <div id="pagetitle" class="page-title bg-image ">
        <div class="container">
            <div class="page-title-inner">
                <div class="image-overlay"></div>
                <div class="page-title-holder">
                    <h1 class="title-main">Services</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')


    @foreach ($services as $service)
        <section class="row py-3">
            <div class="col-md-6 mb-2 @if($loop->iteration % 2 == 0) order-2 @endif">
                <img src="{{ $service->image_url }}" class="h-100 w-100" alt="{{ $service->title }}">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="">
                    <header class="fw-bold ff-montserrat h3">{{ $service->title }}</header>
                    <div class="mb-3">
                        {{ $service->page_description }}
                    </div>
                    <a href="{{ $service->url }}" class="btn btn-primary btn-lg px-4">Learn More

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="hero-icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>

                    </a>
                </div>
            </div>
        </section>
    @endforeach
    {{ $services->links() }}

@endsection
