<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Show search page.
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request): View
    {
        $request->validate([
            "search_query" => ["required", "string", "max:255"],
        ]);

        $search_query = $request->get("search_query");
        $products = Item::whereHas('category', function ($query) {
            return $query->website()->active();
        })->website()->active()
            ->where("name", "LIKE", "%{$search_query}%")
            ->orWhere("code", "LIKE", "%{$search_query}%")
            ->with("category")->paginate(16);

        return view("search.show", [
            "products" => $products,
            "search_query" => $search_query,
        ]);
    }
}
