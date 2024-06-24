<?php

namespace App\Http\Controllers\Admin\Item;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ItemImageController extends Controller
{
    /**
     * Delete item image from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Item $item): JsonResponse
    {
        $item->deleteImage();
        Cache::forget(Category::CACHE_KEY);
        Cache::forget(Category::POS_CACHE_KEY);
        Cache::forget(Category::ANDROID_APP_CACHE_KEY);
        Cache::forget(Category::IOS_APP_CACHE_KEY);
        Cache::forget($item->cache_key);
        Cache::forget(Item::SIMILAR_ITEMS_CACHE_KEY);
        Cache::forget(Item::LATEST_ITEMS_CACHE_KEY);
        Cache::forget(Item::DISCOUNT_ITEMS_CACHE_KEY);
        Cache::forget(Item::RANDOM_ITEMS_CACHE_KEY);
        return $this->jsonResponse();
    }
}
