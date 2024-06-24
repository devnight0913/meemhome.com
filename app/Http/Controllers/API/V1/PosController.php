<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryItemResources\CategoryItemResourceCollection;
use App\Http\Resources\Pos\PosCategoryResourceCollection;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class PosController extends Controller
{

    private const ACCESS_TOKEN = "$8e@*h$@a(!b";

    /**
     * Display a listing of the active resource.
     *
     * @return \Illuminate\Http\JsonResponse     
     */
    public function index(Request $request): JsonResponse
    {
        if (!Hash::check(self::ACCESS_TOKEN, $request->access_token)) {
            abort(Response::HTTP_NOT_FOUND);
        }
        return $this->jsonResponse(["data" => new PosCategoryResourceCollection(
            Cache::rememberForever(Category::POS_CACHE_KEY, function () {
                return Category::with(['items' =>  function ($query) {
                    $query->pos()->active()->orderBy('name', 'ASC');
                }])->pos()->active()->orderBy('sort_order', 'ASC')->orderBy('name', 'ASC')->get();
            })
        )]);
    }


    public function inventoryQuantity(Request $request, Item $item, int $quantity)
    {
        if (!Hash::check(self::ACCESS_TOKEN, $request->access_token)) {
            abort(Response::HTTP_NOT_FOUND);
        }
        if ($item->track_stock) {
            $item->in_stock -= $quantity;
            $item->save();
        }
        return $this->jsonResponse();
    }
    public function inventoryQuantityAdd(Request $request, Item $item, int $quantity)
    {
        if (!Hash::check(self::ACCESS_TOKEN, $request->access_token)) {
            abort(Response::HTTP_NOT_FOUND);
        }
        if ($item->track_stock) {
            $item->in_stock += $quantity;
            $item->save();
        }
        return $this->jsonResponse();
    }
}
