<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Show order page.
     * 
     * @return \Illuminate\View\View
     */
    public function show(): View
    {

        return view('order.show', [
            'address' => Settings::getAddressValue(),
            'gmShareLink' => Settings::getGoogleMapsShareLinkValue()
        ]);
    }
}
