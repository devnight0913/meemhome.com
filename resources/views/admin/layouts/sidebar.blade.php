{{-- <div class="bg-sidebar sticky-top shadow-sm" id="sidebar-wrapper" role="tablist">
    <div class="sidebar-heading pb-0">
        <img src="{{ asset('images/webp/logo_gray.webp') }}" height="35" alt="{{ config('app.name') }}">
    </div>
    <div class="list-group list-group-flush my-2">

        @foreach ($items as $item)
            <a class="list-group-item list-group-item-action sidebar-item align-items-center d-flex py-3
            @if ($item['active']) active-sidebar-item @endif"
                href="{{ $item['route'] }}" @if ($item['is_blank']) target="_blank" @endif>
                {!! $item['icon'] !!} {{ $item['name'] }}
            </a>
        @endforeach
    </div>
</div> --}}


<div class="k-sidebar shadow-sm" role="tablist">
    <div class="list-group list-group-flush">

        @foreach ($items as $item)
            @if ($item['show'])
                <a class="list-group-item list-group-item-action sidebar-item align-items-center d-flex py-3 @if ($item['active']) border-start border-end-0 border-top-0 border-bottom-0 border-active-sidebar-item text-active-sidebar-item border-4 @endif"
                    href="{{ $item['route'] }}" @if ($item['is_blank']) target="_blank" @endif>
                    {!! $item['icon'] !!} {{ $item['name'] }}
                </a>
            @endif
        @endforeach
    </div>
</div>
<div class="offcanvas offcanvas-start" style="background-color: #2d2d2d" tabIndex="-1" id="offcanvasSidebar"
    aria-labelledby="offcanvasSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasSidebarLabel"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        @foreach ($items as $item)
            @if ($item['show'])
                <a class="list-group-item list-group-item-action sidebar-item align-items-center d-flex p-3 @if ($item['active']) text-active-sidebar-item @endif"
                    href="{{ $item['route'] }}" @if ($item['is_blank']) target="_blank" @endif>
                    {!! $item['icon'] !!} {{ $item['name'] }}
                </a>
            @endif
        @endforeach
    </div>
</div>
