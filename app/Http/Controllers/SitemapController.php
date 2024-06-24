<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;

class SitemapController extends Controller
{


    /**
     * Show sitemaps.
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index()
    {
        $items = Item::latest()->paginate(100);

        return response()->view('sitemap.index', [
            'items' => $items,
        ])->header('Content-Type', 'text/xml');
    }

    /**
     * Show sitemap 0.
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function sitemap0()
    {
        return response()->view('sitemap.sitemap-0')->header('Content-Type', 'text/xml');
    }

    /**
     * Show sitemap 1.
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function sitemap1()
    {
        $categories = Category::latest()->get();
        return response()->view('sitemap.sitemap-1', compact('categories'))->header('Content-Type', 'text/xml');
    }

    /**
     * Show sitemap forItem.
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function show()
    {
        $items = Item::latest()->paginate(100);
        return response()->view('sitemap.show', compact('items'))->header('Content-Type', 'text/xml');
    }
}
