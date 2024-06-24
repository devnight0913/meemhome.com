@extends('layouts.app')
@section('title', $search_query . ' - ' . config('app.name'))
@section('content')
    @if ($products->isEmpty())
        <div class="text-center">
            <img src="{{ asset('images/webp/no-results.webp') }}" class="img-fluid" alt="no-results-image">
            <h3>No results found</h3>
            <div class=" text-muted">Try different keywords</div>
        </div>
    @else
        <section>
            <div class="h3 text-uppercase fw-bold mb-1">
                Search results for <span>«</span>{{ $search_query }}<span>»</span>
            </div>
            <div class="text-muted mb-3">Found ({{ $products->total() }}) results</div>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-6 mb-4 d-flex align-items-stretch">
                        <x-product :product="$product"></x-product>
                    </div>
                @endforeach
            </div>
            <div>
                {{ $products->appends(Request::all())->links() }}
            </div>
        </section>
    @endif
@endsection
