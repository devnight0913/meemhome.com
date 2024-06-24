@extends('layouts.app')
@section('title', $category->page_title)
@section('description', $category->page_description)
@section('keywords', $category->page_keywords)
@section('og_image', $category->image_url)
@section('og_url', $category->url)
@section('og_type', $category->name)

@if (count($category->subcategories))
    @push('head')
        <link rel="preload" href="{{ asset('assets/owl.carousel.css') }}" as="style" />
        <link rel="stylesheet" href="{{ asset('assets/owl.carousel.css') }}">
    @endpush
@endif


@section('header')
    <div id="pagetitle" class="bg-primary position-relative">
        <div id="particals"></div>
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="page-title-inner">
                <div class="image-overlay"></div>
                <div class="page-title-holder">
                    <div class="title-main">{{ $category->name }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    @if (count($category->subcategories))
        <div class="categoires-carousel mb-5">
            <div class="owl-carousel mb-3 owl-loaded owl-drag">
                <div class="owl-stage-outer">
                    <div class="owl-stage d-flex justify-content-center"
                        style="margin:auto; transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1307px;">
                        @foreach ($category->subcategories as $subcategory)
                            <div class="owl-item active me-4" style="width: 176.667px; margin-right: 10px;">
                                <a href="{{ $subcategory->url }}" class=" text-decoration-none text-body">
                                    <div class="text-grey text-center">
                                        <div class="image-wrapper mb-4">
                                            <img class="contain rounded-circle" style="    border: 6px solid #bdbebf;"
                                                src="{{ $subcategory->image_url_original }}?w=200&h=200&fit=fill-max&bg=white&fm=webp"
                                                alt="{{ $subcategory->name }}">
                                        </div>
                                        <p class="fw-bold text-uppercase"> {{ $subcategory->name }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if ($category->is_active)
        @if ($items->isEmpty())
            <div class="d-flex justify-content-center">
                <img src="{{ asset('images/webp/box.webp') }}" class="img-fluid" alt="box">
            </div>
            <div class="h3 text-center py-3 ff-montserrat">No Products in this category yet</div>
        @else
            <section class="py-3">
                <div class="row">
                    <div class="col-md-3">
                        @include('category.filter')
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            @foreach ($items as $product)
                                <div class="col-md-4 mb-3 d-flex align-items-stretch">
                                    <x-product :product="$product"></x-product>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            {{ $items->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @else
        <div class="text-danger h5">Temporarily not available.</div>
    @endif
@endsection

@if (count($category->subcategories))
    @push('script')
        <script src="{{ asset('assets/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/jquery-ui.min.js') }}"></script>
        <script type="text/javascript">
            var categoires_carousel = $('.categoires-carousel .owl-carousel').owlCarousel({
                margin: 10,
                dots: true,
                dotsContainer: '.categoires-carousel .carousel-custom-dots',
                responsive: {
                    0: {
                        items: 2,
                    },
                    768: {
                        items: 4,
                    },
                    992: {
                        items: 6,
                    }
                }
            });
        </script>
    @endpush
@endif

@push('script')
    <script>
        particlesJS.load('particals', '/particles.json');
    </script>
@endpush
