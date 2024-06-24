@props(['category'])

@if (count($category->subcategories))
    <div class="accordion" id="accordion{{ $category->id }}">
        <div class="accordion-item border-0">
            <button
                class="accordion-button shadow-none collapsed list-group-item list-group-item-action align-items-center py-2 d-flex text-uppercase fw-bold"
                type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $category->id }}" aria-expanded="true"
                aria-controls="collapse{{ $category->id }}">
                @if ($category->icon_url)
                    <img src="{{ $category->icon_url }}" alt="{{ $category->name }}" class="me-2">
                @endif
                <span> {{ $category->name }}</span>
            </button>
            <div id="collapse{{ $category->id }}" class="accordion-collapse collapse"
                aria-labelledby="heading{{ $category->id }}" data-bs-parent="#accordion{{ $category->id }}">
                <div class="accordion-body py-0">
                    <a href="{{ $category->url }}"
                        class="list-group-item list-group-item-action align-items-center py-2 d-flex text-uppercase fw-bold">
                        @if ($category->icon_url)
                            <img src="{{ $category->icon_url }}" alt="{{ $category->name }}" class="me-2">
                        @endif
                        <span> ALL </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="hero-icon-sm ms-auto">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                    @foreach ($category->subcategories as $subcategory)
                        <x-parent-category :category="$subcategory" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@else
    <a href="{{ $category->url }}"
        class="list-group-item list-group-item-action align-items-center py-2 d-flex text-uppercase fw-bold">
        @if ($category->icon_url)
            <img src="{{ $category->icon_url }}" alt="{{ $category->name }}" class="me-2">
        @endif
        <span> {{ $category->name }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="hero-icon-sm ms-auto">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
    </a>
@endif
