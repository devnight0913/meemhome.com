<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Resources\AreaResources\AreaResourceCollection;
use App\Models\Area;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AreaController extends ApiController
{
    /**
     * Display a listing of the active resource.
     *
     * @return \Illuminate\Http\JsonResponse     
     */
    public function index(): JsonResponse
    {
        return $this->jsonResponse(["data" => new AreaResourceCollection(
            Cache::remember(Area::CACHE_KEY, Area::CACHE_TTL, function () {
                return Area::active()->OrderBy('name', 'ASC')->get();
            })
        )]);
    }
}
