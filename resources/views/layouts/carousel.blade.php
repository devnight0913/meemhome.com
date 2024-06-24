@if (!$banners->isEmpty())
    <div id="carouselTechCenterFade" class="carousel slide carousel-fade mb-3" data-bs-ride="carousel">
        <div class="carousel-inner rounded-4">
            @foreach ($banners as $banner)
                <div class="carousel-item @if ($loop->first) active @endif">
                    @if ($banner->url)
                        <a href="{{ $banner->url }}" target="{{ $banner->url_target }}">
                            <img src="{{ $banner->image_url }}" class="d-block rounded-4 img-fluid" alt="{{ $banner->image_alt ?? 'img' }}">
                        </a>
                    @else
                        <img src="{{ $banner->image_url }}" class="d-block rounded-4 img-fluid" alt="{{ $banner->image_alt ?? 'img' }}">
                    @endif
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselTechCenterFade"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselTechCenterFade"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
@endif
