@extends('admin.layouts.app')
@section('title', 'Create New Serial Number')

@section('content')
    <div class="d-flex align-items-center mb-3">
        <div class="flex-grow-1">
            <span class="h5 fw-bold m-0 ff-montserrat">Create Serial Number</span>
        </div>
        <a class="btn btn-outline-primary px-md-4 ms-auto" href="{{ route('admin.serial_numbers') }}">Back to list</a>
    </div>

    <div class="card w-100">
        <div class="card-body">
            @include('admin.serial_numbers.partials.form')
        </div>
    </div>
@endsection
