@extends('admin.layouts.app')
@section('title', 'Order №' . $order->number)

@section('content')
    <form action="{{ route('admin.orders.update', $order) }}" method="POST" role="form">
        @csrf
        @method('PUT')

        <div class="d-flex align-items-center mb-3">
            <div class="flex-grow-1">
                <div class="h3 fw-bold"> Edit Order №{{ $order->number }}</div>
            </div>
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-primary px-4 me-2">
                Back
            </a>
            <button type="submit" class="btn btn-primary px-4">
                Update
            </button>
        </div>
        <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">

            <div class="mb-3">
                <label for="number" class="form-label fw-bold">Order Number</label>
                <input type="text" class="form-control @error('number') is-invalid @enderror" id="number"
                    name="number" value="{{ old('number', $order->number) }}">
                @error('number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label fw-bold">Status</label>

                <select name="status" id="status" class="form-select">

                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" @selected($order->order_status_id == $status->id)> {{ $status->name }}</option>
                    @endforeach

                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="created_at" class="form-label fw-bold">Created At</label>
                <input type="datetime-local" class="form-control @error('created_at') is-invalid @enderror" id="created_at"
                    name="created_at"
                    value="{{ old('created_at', \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i:s')) }}"
                    step="any">
                @error('created_at')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="delivered_at" class="form-label fw-bold">Delivered At</label>
                <input type="datetime-local" class="form-control @error('delivered_at') is-invalid @enderror"
                    id="delivered_at" name="delivered_at"
                    value="{{ old('delivered_at', $order->delivered_at ? \Carbon\Carbon::parse($order->delivered_at)->format('Y-m-d H:i:s') : '') }}"
                    step="any">
                @error('delivered_at')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="form-label fw-bold mb-3">Customer</div>

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name', $order->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ old('email', $order->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label fw-bold">Phone Number</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                    name="phone" value="{{ old('phone', $order->phone) }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label fw-bold">Comment</label>
                <input type="text" class="form-control @error('comment') is-invalid @enderror" id="comment"
                    name="comment" value="{{ old('comment', $order->comment) }}">
                @error('comment')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="mb-3">
                <label for="is_delivery" class="form-label fw-bold">Type</label>

                <select name="is_delivery" id="is_delivery" class="form-select">
                    <option value="1" @selected($order->is_delivery)>Delivery</option>
                    <option value="0" @selected(!$order->is_delivery)>Pickup</option>
                </select>
                @error('is_delivery')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label fw-bold">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                    name="address" value="{{ old('address', $order->address) }}">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="area" class="form-label fw-bold">Area</label>
                <select name="area" id="area" class="form-select @error('area') is-invalid @enderror">
                    <option value=""></option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}" @selected($order->area_id == $area->id)>
                            {{ $area->name }} ({{ $area->view_fee }})
                        </option>
                    @endforeach
                </select>
                @error('area')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </form>

@endsection
