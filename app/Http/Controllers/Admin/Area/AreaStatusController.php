<?php

namespace App\Http\Controllers\Admin\Area;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class AreaStatusController extends Controller
{

    /**
     * Update the specified resource status in storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Area $area): JsonResponse
    {
        $area->update([
            'is_active' => !$area->is_active
        ]);
        Cache::forget(Area::CACHE_KEY);
        return $this->jsonResponse();
    }
}
