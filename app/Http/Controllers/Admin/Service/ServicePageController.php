<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicePageController extends Controller
{
    /**
     * Show Item Page.
     *
     *  @return \Illuminate\View\View
     */
    public function show(): View
    {
        $this->checkPermission('service_access');
        return view('admin.services.show');
    }
}
