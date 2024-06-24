<section class="border border-primary border-2 rounded-0 p-3">
    <header class="d-flex border-bottom border-primary align-items-center mb-3 pb-2">
        <div class="h4 flex-grow-1 mb-0">Filter</div>
        <a href="{{ $category->url }}" class="small text-decoration-none text-danger d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="hero-icon-sm">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Clear
        </a>
    </header>
    <form action="" method="GET">
        <div class="mb-3">
            <input type="search" class="form-control" aria-placeholder="Search" placeholder="Search"
                name="search_query" value="{{ Request::get('search_query') }}">
        </div>
        <div class="mb-3">
            <label for="price" class=" form-label fw-bold mb-1">Price</label>
            <div class="row">
                <div class="col-6">
                    <input type="number" class="form-control" aria-placeholder="Search" placeholder="From"
                        name="price_start" value="{{ Request::get('price_start') }}">
                </div>
                <div class="col-6">
                    <input type="number" class="form-control" aria-placeholder="Search" placeholder="Up to"
                        name="price_end" value="{{ Request::get('price_end') }}">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="sort" class=" form-label fw-bold mb-1">Sort</label>
            <select name="sort" id="sort" class="form-select w-100">
                <option value="default" selected>Default</option>
                <option value="expensive" @selected(Request::get('sort') == 'expensive')>Expensive First</option>
                <option value="cheapest" @selected(Request::get('sort') == 'cheapest')>Cheapest First</option>
                <option value="newest" @selected(Request::get('sort') == 'newest')>Newest</option>
                <option value="alphabetically_az" @selected(Request::get('sort') == 'alphabetically_az')>Alphabetically (A-Z)</option>
                <option value="alphabetically_za" @selected(Request::get('sort') == 'alphabetically_za')>Alphabetically (Z-A)</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="size" class=" form-label fw-bold mb-1">Show Results</label>
            <select name="size" id="size" class="form-select w-100">
                <option value="6" selected>6</option>
                <option value="15" @selected(Request::get('size') == 15)>15</option>
                <option value="25" @selected(Request::get('size') == 25)>25</option>
                <option value="50" @selected(Request::get('size') == 50)>50</option>
                <option value="75" @selected(Request::get('size') == 75)>75</option>
                <option value="100" @selected(Request::get('size') == 100)>100</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
    </form>
</section>
