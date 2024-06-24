<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
    <div class="offcanvas-header">
        @auth
            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" height="30"
                class="me-1 rounded-circle"> {{ Auth::user()->first_name }}
        @endauth

        <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="list-group list-group-flush mb-3">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action py-3">
                    <mt-icon icon="dashboard" styleName="me-2"></mt-icon> @lang('Admin Panel')
                </a>
            @endauth

            @foreach ($items as $item)
                <a href="{{ $item['route'] }}"
                    class="list-group-item list-group-item-action py-3 
                @if ($item['active']) text-primary @endif"
                    @if ($item['is_blank']) target="_blank" @endif>
                    <mt-icon icon="{{ $item['icon'] }}" styleName="me-2"></mt-icon> {{ $item['name'] }}
                </a>
            @endforeach
        </div>
        <div class="mb-3">
            @include('layouts.social-buttons')
        </div>
        <div>
            @include('layouts.copyright')
        </div>
    </div>
</div>
