<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Show cart page.
     *
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        return view('cart.show');
    }
}
