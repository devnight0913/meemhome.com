<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Item;
use App\Models\Review;
use App\Models\Settings;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{

    /**
     * Show home page.
     * 
     * @return \Illuminate\View\View
     */
    public function show(): View
    {

        // $discountProducts = Cache::rememberForever(Item::DISCOUNT_ITEMS_CACHE_KEY, function () {
        //     return Item::whereHas('category', function ($query) {
        //         return $query->website()->active();
        //     })->website()->active()->where('discount', '>', 0)->with('category')->take(8)->get();
        // });

        $latestProducts = Cache::rememberForever(Item::LATEST_ITEMS_CACHE_KEY, function () {
            return Item::whereHas('category', function ($query) {
                return $query->website()->active();
            })->website()->active()->with('category')->latest()->take(8)->get();
        });


        // $randomProducts = Cache::rememberForever(Item::RANDOM_ITEMS_CACHE_KEY, function () {
        //     return Item::whereHas('category', function ($query) {
        //         return $query->website()->active();
        //     })->website()->active()->with('category')->inRandomOrder()->take(8)->get();
        // });

        $parentCategories = Category::where('parent_id', Null)->get();
        
        $banners = Cache::rememberForever(Banner::CACHE_KEY, function () {
            return Banner::active()->orderBy('sort_order', 'ASC')->latest()->get();
        });


        return view('home.show', [
            'global_alert' => Settings::getGlobalAlertValue(),
            // 'discountProducts' => $discountProducts,
            'latestProducts' => $latestProducts,
            // 'randomProducts' => $randomProducts,
            'banners' => $banners,
            'parentCategories' => $parentCategories
        ]);
    }

    /**
     * Show item page.
     *
     * @param string $slug
     * 
     * @return \Illuminate\View\View
     */
    public function showItem(string $id): View
    {
        $item = Cache::remember("item-{$id}", Item::CACHE_TTL, function () use ($id) {
            return Item::whereHas('category', function ($query) {
                return $query->website()->active();
            })->with(['category', 'additional_images'])->website()->where("id", $id)->firstOrFail();
        });

        $reviews = Review::where('item_id', $item->id)->with('user')->latest()->paginate(10);

        $key = "item-{$item->id}";
        if (!session($key)) {
            $item->views += 1;
            $item->save();
            session([$key => 1]);
        }
        return view('home.item', [
            'item' => $item,
            'reviews' => $reviews,
        ]);
    }








    /**
     * Show home page.
     * 
     * @return \Illuminate\View\View
     */
    public function test(): View
    {

        // $discountProducts = Cache::rememberForever(Item::DISCOUNT_ITEMS_CACHE_KEY, function () {
        //     return Item::whereHas('category', function ($query) {
        //         return $query->website()->active();
        //     })->website()->active()->where('discount', '>', 0)->with('category')->take(8)->get();
        // });

        $latestProducts = Cache::rememberForever(Item::LATEST_ITEMS_CACHE_KEY, function () {
            return Item::whereHas('category', function ($query) {
                return $query->website()->active();
            })->website()->active()->with('category')->latest()->take(8)->get();
        });


        // $randomProducts = Cache::rememberForever(Item::RANDOM_ITEMS_CACHE_KEY, function () {
        //     return Item::whereHas('category', function ($query) {
        //         return $query->website()->active();
        //     })->website()->active()->with('category')->inRandomOrder()->take(8)->get();
        // });


        $banners = Cache::rememberForever(Banner::CACHE_KEY, function () {
            return Banner::active()->orderBy('sort_order', 'ASC')->latest()->get();
        });


        return view('home.test', [
            'global_alert' => Settings::getGlobalAlertValue(),
            // 'discountProducts' => $discountProducts,
            'latestProducts' => $latestProducts,
            // 'randomProducts' => $randomProducts,
            'banners' => $banners,
        ]);
    }
}
