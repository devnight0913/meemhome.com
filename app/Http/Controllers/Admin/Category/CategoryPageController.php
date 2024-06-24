<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CategoryPageController extends Controller
{

    /**
     * Show Category Page.
     *
     *  @return \Illuminate\View\View
     */
    public function show(): View
    {
        $this->checkPermission('catalog_access');
        return view('admin.categories.show');
    }
}
