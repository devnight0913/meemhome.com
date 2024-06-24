<div class="d-flex mb-3">
    <div class="dropdown">
        <button class="btn btn-light border px-md-4 mx-3" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
            aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="hero-icon me-1">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25" />
            </svg>
            Sort By
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item"
                    href="?sort=created_at&order=desc{{ request()->has('size') ? '&size=' . request()->get('size') : '' }}{{ request()->has('search_query') ? '&search_query=' . request()->get('search_query') : '' }}">Newest</a>
            </li>
            <li><a class="dropdown-item"
                    href="?sort=created_at&order=asc{{ request()->has('size') ? '&size=' . request()->get('size') : '' }}{{ request()->has('search_query') ? '&search_query=' . request()->get('search_query') : '' }}">Oldes</a>
            </li>
        </ul>
    </div>
    <div class="dropdown">
        <button class="btn btn-light border px-md-4" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
            aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="hero-icon me-1">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
            </svg>
            Results Per Page
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item"
                    href="?size=5{{ request()->has('search_query') ? '&search_query=' . request()->get('search_query') : '' }}{{ request()->has('sort') ? '&sort=' . request()->get('sort') : '' }}{{ request()->has('order') ? '&order=' . request()->get('order') : '' }}">5</a>
            </li>
            <li><a class="dropdown-item"
                    href="?size=10{{ request()->has('search_query') ? '&search_query=' . request()->get('search_query') : '' }}{{ request()->has('sort') ? '&sort=' . request()->get('sort') : '' }}{{ request()->has('order') ? '&order=' . request()->get('order') : '' }}">10</a>
            </li>
            <li><a class="dropdown-item"
                    href="?size=25{{ request()->has('search_query') ? '&search_query=' . request()->get('search_query') : '' }}{{ request()->has('sort') ? '&sort=' . request()->get('sort') : '' }}{{ request()->has('order') ? '&order=' . request()->get('order') : '' }}">25</a>
            </li>
            <li><a class="dropdown-item"
                    href="?size=50{{ request()->has('search_query') ? '&search_query=' . request()->get('search_query') : '' }}{{ request()->has('sort') ? '&sort=' . request()->get('sort') : '' }}{{ request()->has('order') ? '&order=' . request()->get('order') : '' }}">50</a>
            </li>
        </ul>
    </div>
</div>
