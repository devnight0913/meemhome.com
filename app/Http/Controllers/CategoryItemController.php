<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryItemResources\CategoryItemResourceCollection;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CategoryItemController extends Controller
{
    /**
     * Show category page.
     * 
     * @return \Illuminate\View\View
     */
    public function show(Request $request, string $id): View
    {
        $category = Category::where("id", $id)->with('subcategories', function ($query) {
            $query->orderBy('sort_order', 'ASC');
        })->website()->firstOrFail();

        $items = collect();

        if ($category->is_active) {
            if (count($category->subcategories)) {
                $categoriesArray = $category->subcategories->pluck('id')->toArray();
                array_push($categoriesArray, $category->id);
                $itemsQuery = Item::whereIn('category_id', $categoriesArray)->active()->website();
            } else {
                $itemsQuery = $category->items()->active()->website();
            }

            $sizeQuery = (int)$request->get('size', 15);
            $size = 15;
            if (is_int($sizeQuery)) {
                if ($sizeQuery >= 6 && $sizeQuery <= 100) {
                    $size = $sizeQuery;
                }
            }
            $sort = $request->get('sort', 'default');
            if ($sort == 'default') {
                $itemsQuery = $itemsQuery->latest();
            } elseif ($sort == 'expensive') {
                $itemsQuery = $itemsQuery->orderBy('price', 'DESC');
            } elseif ($sort == 'cheapest') {
                $itemsQuery = $itemsQuery->orderBy('price', 'ASC');
            } elseif ($sort == 'newest') {
                $itemsQuery = $itemsQuery->latest();
            } elseif ($sort == 'alphabetically_az') {
                $itemsQuery = $itemsQuery->orderBy('name', 'ASC');
            } elseif ($sort == 'alphabetically_za') {
                $itemsQuery = $itemsQuery->orderBy('name', 'DESC');
            } else {
                $itemsQuery = $itemsQuery->latest();
            }


            $startPrice = $request->get('price_start');
            $endPrice = $request->get('price_end');

            if (!empty($startPrice) && empty($endPrice)) {
                $itemsQuery = $itemsQuery->where('price', '>=', intval($startPrice));
            }
            if (empty($startPrice) && !empty($endPrice)) {
                $itemsQuery = $itemsQuery->where('price', '<=', intval($endPrice));
            }
            if (!empty($startPrice) && !empty($endPrice)) {
                $itemsQuery = $itemsQuery->whereBetween('price', [intval($startPrice), intval($endPrice)]);
            }
            if ($request->has('search_query')) {
                $searchQuery = trim($request->search_query);
                if (!empty($searchQuery)) {
                    $itemsQuery = $itemsQuery->where("name", "LIKE", "%{$searchQuery}%")->orWhere("code", "LIKE", "%{$searchQuery}%");
                }
            }
            $items = $itemsQuery->paginate($size);
        }
        return view('category.show', [
            "category" =>  $category,
            "items" =>  $items,
        ]);
    }
}
