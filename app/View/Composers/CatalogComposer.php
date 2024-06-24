<?php

namespace App\View\Composers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CatalogComposer
{

    /**
     * The category modal implementation.
     *
     * @var \App\Models\category
     */
    protected $category;

    /**
     * Create a new seo composer.
     *
     * @param  \App\Models\Settings  $users
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $catalog = Cache::rememberForever(Category::CATALOG_CACHE_KEY, function () {
            return $this->category->website()->active()->with('subcategories')->whereNull('parent_id')->orderBy('sort_order', 'ASC')->orderBy('name', 'ASC')->get();
        });

        $view->with('categories', $catalog);
    }
}
