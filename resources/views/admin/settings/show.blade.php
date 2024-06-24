@extends('admin.layouts.app')
@section('title', 'Settings')
@push('style')
    <style>
        .container {
            height: 0% !important;
        }

    </style>
@endpush
@section('page_name', 'Settings')
@section('content')
    <settings-component></settings-component>
@endsection
