@extends('admin.layouts.app')
@section('title', 'Customers')
@section('page_name', 'Customers')

@section('content')
    <div class="d-flex align-items-center mb-3">
        <div class="flex-grow-1 h5 fw-bold m-0 ff-montserrat">Customers</div>
    </div>
    <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">

        <div class="d-flex align-items-center mb-3">
            <div class="flex-grow-1  m-0">
                <form action="" role="form" method="GET">
                    <div class="position-relative mb-3">
                        <input type="text" class="form-control w-auto" name="search_query" id="search"
                            autocomplete="off" placeholder="Search..." style="padding-left: 2.5rem !important"
                            value="{{ Request::get('search_query') }}" />
                        <div class="position-absolute top-50 start-0 translate-middle-y p-2">
                            <search-icon-component></search-icon-component>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                @include('admin.customers.sort')
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Total orders</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>
                                <a href="mailto:{{ $customer->email }}" class="link-primary">{{ $customer->email }}</a>
                            </td>
                            <td>
                                <a href="tel:{{ $customer->phone }}" class="link-primary">{{ $customer->phone }}</a>
                            </td>
                            <td>{{ $customer->order_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($customers->isEmpty())
                <no-content-component></no-content-component>
            @endif
            {{ $customers->withQueryString()->links() }}
        </div>
    </div>
@endsection
