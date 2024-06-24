@extends('admin.layouts.app')
@section('title', 'Serial Numbers')
@section('page_name', 'Serial Numbers')
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
            <span class="h5 fw-bold m-0 ff-montserrat">Serial Numbers</span> <span>({{ $numbers->total() }})</span>
        </div>
        <a class="btn btn-primary px-md-4 ms-auto" href="{{ route('admin.serial_numbers.create') }}">Create New</a>
    </div>
    <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">

        <div class="d-flex align-items-center mb-3">
            <div class="flex-grow-1  m-0">
                <form action="" role="form" method="GET">
                    <div class="position-relative mb-3">
                        <input type="search" class="form-control w-auto" name="search_query" id="search"
                            autocomplete="off" placeholder="Search..." style="padding-left: 2.5rem !important"
                            value="{{ Request::get('search_query') }}" />
                        <div class="position-absolute top-50 start-0 translate-middle-y p-2">
                            <search-icon-component></search-icon-component>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th>Serial Number</th>
                        <th>Product</th>
                        <th>Warranty End Date</th>
                        <th>Purchase Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($numbers as $number)
                        <tr>
                            <td class="fw-bold">
                                <a href="{{ route('admin.serial_numbers.show', $number) }}" class=" link-primary fw-bold">
                                    {{ $number->serial_numbers_view }}
                                </a>
                            </td>
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
                            <td>{{ $number->warranty_end_date_view }}</td>
                            <td>{{ $number->purchase_date_view }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.serial_numbers.show', $number) }}"
                                        class="btn btn-xs rounded-0 btn-success me-2">Show</a>

                                    <a href="{{ route('admin.serial_numbers.edit', $number) }}"
                                        class="btn btn-xs rounded-0 btn-info me-2">Edit</a>

                                    <form action="{{ route('admin.serial_numbers.destroy', $number) }}" method="POST"
                                        id="form-{{ $number->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-xs rounded-0 btn-danger"
                                            onclick="submitDeleteForm('{{ $number->id }}')">
                                            @lang('Delete')
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $numbers->withQueryString()->links() }}
            @if ($numbers->isEmpty())
                <no-content-component></no-content-component>
            @endif
        </div>


    </div>

@endsection
@push('script')
    <script>
        function submitDeleteForm(id) {
            const form = document.querySelector(`#form-${id}`);
            Swal.fire({
                title: 'Are you sure?',
                text: 'You cannot undo this action!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6473f4',
                cancelButtonColor: '#d93025',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    topbar.show();
                    form.submit();
                } else {
                    topbar.hide();
                }
            });
        }
    </script>
@endpush
