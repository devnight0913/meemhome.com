<?php

namespace App\Http\Controllers\Admin\Item;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ItemPageController extends Controller
{
     /**
     * Show Item Page.
     *
     *  @return \Illuminate\View\View
     */
    public function show(): View
    {
        $this->checkPermission('product_access');
        return view('admin.items.show');
    }
 
}
