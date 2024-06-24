@props(['category'])
<a class="splide__slide p-3 category-navigation-classifier text-decoration-none border" href="{{ $category->url }}">
    <picture>
        <source type="image/jpg" data-srcset="{{ $category->splide_slide_image }}" />
        <img alt="{{ $category->name }}" data-src="{{ $category->splide_slide_image }}" aria-hidden="true"
            class="lazy w-100  loading mb-2" />
    </picture>
    <div class="text-center text-dark">
        {{ $category->name }}
    </div>
</a>
