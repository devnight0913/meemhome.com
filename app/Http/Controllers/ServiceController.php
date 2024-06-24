<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $services = Service::active()->orderBy('sort_order', 'ASC')->paginate(10);
        return view('services.index', [
            'services' => $services
        ]);
    }


    public function show(Request $request, string $id): View
    {
        $service = Service::active()->findOrFail($id);
        return view('services.show', [
            'service' => $service
        ]);
    }
}
