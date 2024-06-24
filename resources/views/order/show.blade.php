@extends('layouts.app')
@section('title', 'Submit your order')

@section('content')
    {{-- @auth
        <submit-order-component :user="{{ Auth::user() }}"></submit-order-component>
    @else
        @include('auth.login', ['next' => 'order', 'title' => 'Login to your account so you can order'])
    @endauth --}}
    @auth
        <submit-order-component :user="{{ Auth::user() ?? '' }}" address="{{ $address }}" link="{{ $gmShareLink }}">
        </submit-order-component>
    @endauth
    @guest
        <submit-order-component user="" address="{{ $address }}" link="{{ $gmShareLink }}"></submit-order-component>
    @endguest


@endsection
