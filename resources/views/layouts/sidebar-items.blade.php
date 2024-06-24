@php
$items = [
    [
        'name' => 'Our Menu',
        'route' => route('home'),
        'icon' => 'fastfood',
        'active' => Route::currentRouteName() == 'home',
        'is_blank' => false,
    ],
    [
        'name' => 'Bag',
        'route' => route('cart'),
        'icon' => 'local_mall',
        'active' => Route::currentRouteName() == 'cart',
        'is_blank' => false,
    ],
    [
        'name' => 'Contact',
        'route' => route('contact'),
        'icon' => 'pin_drop',
        'active' => Route::currentRouteName() == 'contact',
        'is_blank' => false,
    ],
    [
        'name' => 'About Us',
        'route' => route('about'),
        'icon' => 'info',
        'active' => Route::currentRouteName() == 'about',
        'is_blank' => false,
    ],
];

@endphp
@include('layouts.sidebar')