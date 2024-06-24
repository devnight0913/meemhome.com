@extends('layouts.app')
@section('title', $service->title . ' | ' . config('app.name'))
@section('description', $service->description)
@section('keywords', $service->page_keywords)
@section('og_image', $service->image_url)
@section('og_url', $service->url)
@section('og_type', 'service')
@section('header')
    <div id="pagetitle" class="page-title bg-image ">
        <div class="container">
            <div class="page-title-inner">
                <div class="image-overlay"></div>
                <div class="page-title-holder">
                    <h1 class="title-main">{{ $service->title }}</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')


    <section class="py-3">
        @if ($service->image_path)
            <figure class="my-4 text-center">
                <img class=" img-fluid rounded-2" src="{{ $service->image_url_og }}" alt="{{ $service->title }}">
            </figure>
        @endif
        <section>
            {!! $service->description !!}
        </section>
        @include('services.share-buttons')
    </section>
@endsection
