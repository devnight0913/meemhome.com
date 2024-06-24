@extends('layouts.app')
@section('title', $item->page_title)
@section('description', $item->page_description)
@section('keywords', $item->page_keywords)
@section('og_image', $item->image_url)
@section('og_url', $item->url)
@section('og_type', $item->category->name)
@push('head')
    <link rel="preload" href="{{ mix('css/splide.css') }}" as="style" />
    <link rel="stylesheet" href="{{ mix('css/splide.css') }}">
    <script src="{{ mix('js/splide.js') }}"></script>

    {{-- <script type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=63720437bbc41e001915d9dc&product=sop'
        async='async'></script> --}}
    <style>
        .splide {
            margin: 0 auto;
        }

        .thumbnails {
            display: flex;
            margin: 1rem auto 0;
            padding: 0;
            justify-content: center;
        }

        .thumbnail {
            width: 70px;
            height: 70px;
            overflow: hidden;
            list-style: none;
            margin: 0 0.2rem;
            cursor: pointer;
            opacity: 0.3;
        }

        .thumbnail.is-active {
            opacity: 1;
        }

        .thumbnail img {
            width: 70px;
            height: 70px;
            object-fit: cover
        }
    </style>
@endpush

@section('header')
    <div id="pagetitle" class="bg-primary position-relative">
        <div id="particals"></div>
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="page-title-inner">
                <div class="image-overlay"></div>
                <div class="page-title-holder">
                    <div class="title-main">{{ $item->name }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='9'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='black'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb" class="my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="link-primary">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ $item->category->url }}"
                    class="link-primary">{{ $item->category->name }}</a></li>

        </ol>
    </nav> --}}
    <div class="border p-3 rounded-4">
        {{-- <div class="fw-bold text-break text-uppercase h3 ff-montserrat mb-3">
            {{ $item->name }}
        </div> --}}
        <div class="row pb-3 mb-3">
            <div class="col-lg-6 col-md-12 mb-3">
                <div class="pb-3">
                    <div id="main-slider" class="splide">
                        <div class="splide__track">
                            <ul class="splide__list">
                                <li class="splide__slide rounded-2">
                                    <img src="{{ $item->image_url }}">
                                </li>
                                @foreach ($item->additional_images as $additional_image)
                                    <li class="splide__slide rounded-2">
                                        <img src="{{ $additional_image->image_url }}">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <ul id="thumbnails" class="thumbnails">
                        <li class="thumbnail rounded-2">
                            <img src="{{ $item->sm_thumbnail_image_url }}">
                        </li>
                        @foreach ($item->additional_images as $additional_image)
                            <li class="thumbnail rounded-2">
                                <img src="{{ $additional_image->thumbnail_url }}">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-lg-6 col-md-12 mb-3 px-lg-5">
                @if ($item->data_sheet_path)
                    <div class="mb-3">
                        <a href="{{ asset('storage/' . $item->data_sheet_path) }}"
                            class="btn btn-primary w-100 d-flex align-items-center justify-content-center py-2"
                            download="{{ $item->name }}-{{ $item->code ?? 'proton' }}.pdf">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" style="width: 1.25rem;height:1.25rem;" class="me-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Data Sheet
                        </a>
                    </div>
                @endif

                {{-- <div class="mb-3">
                    <a href="{{ $item->image_download }}"
                        class="btn btn-primary w-100 d-flex align-items-center justify-content-center py-2"
                        download="{{ $item->name }}-{{ $item->code ?? 'proton' }}.jpg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" style="width: 1.25rem;height:1.25rem;" class="me-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        Download Image
                    </a>
                </div> --}}
                <div>
                    Category: <a href="{{ $item->category->url }}" class=" link-primary">{{ $item->category->name }}</a>
                </div>
                <div class="mb-2">
                    @if ($item->code)
                        <div>Product Code: {{ $item->code }}</div>
                    @endif
                    @if ($item->sku)
                        <div class="text-muted small">SKU: {{ $item->sku }}</div>
                    @endif
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="me-1">
                        @for ($i = 0; $i < $item->avg_rating; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                style="width: 1.25rem;height:1.25rem;" class=" text-warning">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endfor

                        @for ($i = 0; $i < 5 - $item->avg_rating; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" style="width: 1.25rem;height:1.25rem;" class=" text-warning">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        @endfor
                    </div>
                    <a href="#reviews" class="btn btn-link p-0">
                        {{ number_format($item->sum_rating) }} Reviews
                    </a>
                </div>


                <div class="mb-3">
                    @if ($item->available)
                        <div class="mb-3">
                            <item-cart-component :item="{{ $item }}" />
                        </div>
                    @else
                        {{-- <div class="fw-bolder h3 mb-2">
                            <span class="{{ $item->has_discount ? 'text-danger' : '' }}">{{ $item->view_price }}</span>
                            @if ($item->has_discount)
                                <s class="ms-2">{{ $item->view_original_price }}</s>
                            @endif
                        </div> --}}
                        <div class="text-danger h5 fw-bold">
                            @lang('Temporarily not available.')
                        </div>
                    @endif
                </div>

                <section class="py-3">
                    <header class="h3 text-center mb-0 text-uppercase ff-montserrat">Share</header>
                    <div class="c-underline">&nbsp;</div>

                    @include('home.share-buttons')
                </section>

            </div>
        </div>
        @if ($item->description)
            <section class="mb-3">
                <header class="text-uppercase ff-montserrat h4 fw-bold">Description</header>
                <div class="mb-3">
                    {!! $item->description !!}
                </div>
            </section>
        @endif
        <section class="mb-3" id="reviews">
            <header class="text-uppercase ff-montserrat h4 fw-bold">
                Reviews ({{ number_format($item->sum_rating) }})
            </header>

            <div class="d-flex align-items-center mb-3">
                <div class="me-1">
                    @for ($i = 0; $i < $item->avg_rating; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            style="width: 2rem;height:2rem;" class=" text-warning">
                            <path fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                clip-rule="evenodd" />
                        </svg>
                    @endfor

                    @for ($i = 0; $i < 5 - $item->avg_rating; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" style="width: 2rem;height:2rem;" class=" text-warning">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                    @endfor
                </div>
            </div>
            <div class="mb-3">
                @auth
                    <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal"
                        data-bs-target="#reviewModal">
                        Write a review
                    </button>
                @else
                    <a href="{{ route('login') }}" class="btn btn-link p-0">
                        Login to write a review
                    </a>
                @endauth
            </div>

            @auth
                <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="reviewModalLabel"> Write a review</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ Auth::user()->profile_photo_url_small }}" alt="{{ Auth::user()->name }}"
                                        class="profile-photo rounded-circle me-2" height="45">
                                    <div>
                                        <div>{{ Auth::user()->first_name }}</div>
                                        <div class="small text-muted">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>

                                <review-form-component :user="{{ Auth::user() }}" :item="{{ $item }}">
                                </review-form-component>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            <div class="mb-3">
                @foreach ($reviews as $review)
                    <section class="mb-3">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center mb-1 flex-grow-1">
                                <div class="me-2">
                                    <img src="{{ $review->user->profile_photo_url_medium }}"
                                        alt="{{ $review->user->name }}" width="45" height="45"
                                        class="rounded-circle">
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $review->user->name }}</div>
                                    <div class="text-muted small">{{ $review->display_date }}</div>
                                </div>
                            </div>
                            @auth
                                @if ($review->user->id == Auth::id() || Auth::user()->is_admin)
                                    <button type="button" class="btn btn-link text-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#reviewEditModal{{ $review->id }}">
                                        Edit
                                    </button>
                                    <div class="modal fade" id="reviewEditModal{{ $review->id }}" tabindex="-1"
                                        aria-labelledby="reviewEditModalLabel{{ $review->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5"
                                                        id="reviewEditModalLabel{{ $review->id }}"> Write a review
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="d-flex align-items-center mb-3">
                                                        <img src="{{ Auth::user()->profile_photo_url_small }}"
                                                            alt="{{ Auth::user()->name }}"
                                                            class="profile-photo rounded-circle me-2" height="45">
                                                        <div>
                                                            <div>{{ Auth::user()->first_name }}</div>
                                                            <div class="small text-muted">{{ Auth::user()->email }}</div>
                                                        </div>
                                                    </div>

                                                    <review-form-edit-component :user="{{ Auth::user() }}"
                                                        :item="{{ $item }}" :review="{{ $review }}">
                                                    </review-form-edit-component>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                                        onSubmit="if(confirm('Are you sure?') == true) { return true;}else{  topbar.hide(); return false;}"
                                        class="">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger btn-sm">Delete</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        <div>
                            @for ($i = 0; $i < $review->rating; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    style="width: 1rem;height:1rem;" class=" text-warning">
                                    <path fill-rule="evenodd"
                                        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endfor

                            @for ($i = 0; $i < 5 - $review->rating; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" style="width: 1rem;height:1rem;"
                                    class=" text-warning">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                            @endfor
                        </div>
                        <div id="comment-full">
                            {!! nl2br(e($review->comment)) !!}
                        </div>
                    </section>
                    <hr>
                @endforeach
                <div class="mt-3">
                    {{ $reviews->withQueryString()->links() }}
                </div>
                @if ($reviews->isEmpty())
                    <div class="text-center">
                        <img src="{{ asset('images/webp/i-review.png') }}" alt="i-review" style="width: 200px;">
                        <h4 class="fw-bold">Be the first to review</h4>
                        <div>Help other buyers with a choice,</div>
                        <div class="mb-3">leave your review about the product</div>
                        @auth
                            <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal"
                                data-bs-target="#reviewModal">
                                Write a review
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-link p-0">
                                Login to write a review
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </section>
    </div>
    {{-- <div>
        <script src="https://apps.elfsight.com/p/platform.js" defer></script>
        <div class="elfsight-app-20707f1c-d98e-4533-9afc-754e794d90dd"></div>
    </div> --}}
@endsection
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var splide = new Splide("#main-slider", {
                heightRatio: 1,
                pagination: true,
                type: 'loop',
                cover: true
            });

            var thumbnails = document.getElementsByClassName("thumbnail");
            var current;

            for (var i = 0; i < thumbnails.length; i++) {
                initThumbnail(thumbnails[i], i);
            }

            function initThumbnail(thumbnail, index) {
                thumbnail.addEventListener("click", function() {
                    splide.go(index);
                });
            }

            splide.on("mounted move", function() {
                var thumbnail = thumbnails[splide.index];

                if (thumbnail) {
                    if (current) {
                        current.classList.remove("is-active");
                    }

                    thumbnail.classList.add("is-active");
                    current = thumbnail;
                }
            });

            splide.mount();
        });
    </script>
@endpush
@push('script')
    <script>
        particlesJS.load('particals', '/particles.json');
    </script>
@endpush
