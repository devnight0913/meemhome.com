<div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
    <div class="h3 fw-bold ff-montserrat">
        Popular Products
    </div>
    <div class=" table-responsive">
        <table class="table table-striped table-hover table-bordered w-100 mb-0">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Total Ordered</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($popular_items as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $item->item->image_url }}" class="rounded-circle me-2" alt="image"
                                    width="50" height="50">
                                <a href="{{ $item->item->url }}" class="link-primary">{{ $item->item->name }}</a>
                            </div>
                        </td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($popular_items->isEmpty())
            <no-content-component></no-content-component>
        @endif
    </div>
</div>
