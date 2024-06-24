@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page_name', 'Dashboard')

@section('content')

    @include('admin.dashboard.partials.cards')

    <div class="row">
        <div class="col-md-6 mb-3">
            @include('admin.dashboard.partials.orders-chart')
        </div>
        <div class="col-md-6 mb-3">
            @include('admin.dashboard.partials.sales-chart')
        </div>
    </div>


    @include('admin.dashboard.partials.latest-orders-table')
    @include('admin.dashboard.partials.popular-items-table')
    @include('admin.dashboard.partials.orders-report-table')

@endsection
