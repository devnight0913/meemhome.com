<?php

namespace App\Http\Controllers\Admin\Area;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AreaPageController extends Controller
{
    /**
     * Show Category Page.
     *
     *  @return \Illuminate\View\View
     */
    public function show(): View|RedirectResponse
    {
        $this->checkPermission('area_access');
        return view('admin.areas.show');
    }
}
