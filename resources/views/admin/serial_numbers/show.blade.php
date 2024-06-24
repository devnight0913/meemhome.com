@extends('admin.layouts.app')
@section('title', 'Serial Number')
@push('head')
    <style>
        td {
            vertical-align: middle;
        }
    </style>
@endpush
@section('content')
    <div class="d-flex align-items-center mb-3">
        <div class="flex-grow-1">
            <span class="h5 fw-bold m-0 ff-montserrat">Serial Number</span>
        </div>
        <div>
            <a class="btn btn-outline-primary px-md-4 me-2" href="{{ route('admin.serial_numbers') }}">Back to list</a>
            <a class="btn btn-primary px-md-4" href="{{ route('admin.serial_numbers.edit', $number) }}">Edit</a>
        </div>
    </div>

    <div class="card w-100">
        <div class="card-body">
            <div class=" table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <tbody>
                        <tr>
                            <td class="fw-bold">Serial Numbers</td>
                            <td>
                                <textarea class=" form-control border-0 rounded-0" rows="6" readonly>{{ $number->exploded_serial_numbers }}</textarea>
                            </td>
                        </tr>

                        <tr>
                            <td class="fw-bold">Product</td>
                            <td>
                                <a href="{{ $number->item->url }}" target="_blank" class=" link-primary">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <img src="{{ $number->item->sm_thumbnail_image_url }}" alt="">
                                        </div>
                                        <div>
                                            <div>{{ $number->item->name }}</div>
                                            @if ($number->item->code)
                                                <div class="small">
                                                    <span class=" text-dark">Product Code:</span> {{ $number->item->code }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="fw-bold">Warranty End Date</td>
                            <td>{{ $number->warranty_end_date_view }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Purchase Date</td>
                            <td>{{ $number->purchase_date_view }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Notes</td>
                            <td>{{ $number->notes }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
