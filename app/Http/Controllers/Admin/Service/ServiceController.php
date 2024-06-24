<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResourceCollection;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $this->checkPermission('service_access');
        return $this->jsonResponse(['data' => new ServiceResourceCollection(
            Service::orderBy('sort_order', 'ASC')->latest()->get()
        )]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->checkPermission('service_create');
        $request->validate([
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'max:2024'],
            'sort_order' => ['required', 'numeric', 'min:1'],
        ]);

        $service = Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order,
            'is_active' => true,
        ]);

        if ($request->image) {
            $service->updateImage($request->image);
        }

        return $this->jsonResponse();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Service $service): JsonResponse
    {
        $this->checkPermission('service_edit');
        $request->validate([
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'max:2024'],
            'sort_order' => ['required', 'numeric', 'min:1'],
        ]);

        $service->update([
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order,
        ]);

        if ($request->image) {
            $service->updateImage($request->image);
        }

        return $this->jsonResponse(['data' => $service]);
    }

    /**
     * Update the specified resource status in storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Service $service): JsonResponse
    {
        $this->checkPermission('service_edit');
        $service->update([
            'is_active' => !$service->is_active
        ]);
        return $this->jsonResponse();
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Service $service): JsonResponse
    {
        $this->checkPermission('service_delete');
        $service->delete();
        return $this->jsonResponse();
    }
}
