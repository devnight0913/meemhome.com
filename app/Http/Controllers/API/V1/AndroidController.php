<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Android\AndroidCategoryResourceCollection;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AndroidController extends Controller
{
    /**
     * Display a listing of the active resource.
     *
     * @return \Illuminate\Http\JsonResponse     
     */
    public function index(): JsonResponse
    {
        return $this->jsonResponse(["data" => new AndroidCategoryResourceCollection(
            Cache::rememberForever(Category::ANDROID_APP_CACHE_KEY, function () {
                return Category::with(['items' =>  function ($query) {
                    $query->androidApp()->with('additional_images')->active()->orderBy('name', 'ASC');
                }])->androidApp()->active()->orderBy('sort_order', 'ASC')->orderBy('name', 'ASC')->get();
            })
        )]);
    }
}
