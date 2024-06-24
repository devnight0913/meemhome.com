<?php

namespace App\Http\Controllers\Admin\Area;

use App\Http\Controllers\Controller;
use App\Http\Requests\AreaRequests\AreaStoreRequest;
use App\Http\Requests\AreaRequests\AreaUpdateRequest;
use App\Http\Resources\AreaResources\AreaResourceCollection;
use App\Models\Area;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class AreaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $this->checkPermission('area_access');
        return $this->jsonResponse(['data' => new AreaResourceCollection(
            Area::orderBy('name', 'ASC')->get()
        )]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AreaRequests\AreaStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AreaStoreRequest $request): JsonResponse
    {
        Area::create([
            'name' => $request->name,
            'fee' => $request->fee ?? 0,
            'time' => $request->time ?? 0,
            'is_active' => true,
        ]);
        Cache::forget(Area::CACHE_KEY);
        return $this->jsonResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AreaRequests\AreaUpdateRequest  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AreaUpdateRequest $request, Area $area): JsonResponse
    {
        $area->update([
            'name' => $request->name,
            'fee' => $request->fee,
            'time' => $request->time,
        ]);
        Cache::forget(Area::CACHE_KEY);
        return $this->jsonResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Area $area): JsonResponse
    {
        $area->delete();
        Cache::forget(Area::CACHE_KEY);
        return $this->jsonResponse();
    }
}
