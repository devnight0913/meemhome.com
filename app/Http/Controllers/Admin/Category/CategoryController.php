<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequests\CategoryStoreRequest;
use App\Http\Requests\CategoryRequests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResources\CategoryResourceCollection;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(): JsonResponse
    {
        $this->checkPermission('catalog_access');
        return $this->jsonResponse(['data' => new CategoryResourceCollection(
            Category::orderBy('sort_order', 'ASC')->get()
        )]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $this->checkPermission('catalog_access');
        return $this->jsonResponse(['data' => new CategoryResourceCollection(
            Category::whereNull('parent_id')->with('subcategories', function ($query) {
                $query->orderBy('sort_order', 'ASC');
            })->orderBy('sort_order', 'ASC')->get()
        )]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequests\CategoryStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $this->checkPermission('category_create');

        $category = new Category();
        $category->name = $request->name;
        $category->sort_order = $request->sort_order;
        $category->status_id = $request->status;
        $category->pos =  $request->has('pos');
        $category->website =  $request->has('website');
        $category->android_app =  $request->has('android_app');
        $category->ios_app =  $request->has('ios_app');
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->keywords = $request->keywords;
        $category->parent_id = $request->parent_id;
        $category->save();

        if ($request->image) {
            $category->updateIcon($request->image);
        }
        if ($request->cover_image) {
            $category->updateCoverImage($request->cover_image);
        }

        $this->forgetCache();
        return $this->jsonResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequests\CategoryUpdateRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category): JsonResponse
    {
        $this->checkPermission('category_edit');
        $category->name = $request->name;
        $category->sort_order = $request->sort_order;
        $category->status_id = $request->status;
        $category->pos =  $request->has('pos');
        $category->website =  $request->has('website');
        $category->android_app =  $request->has('android_app');
        $category->ios_app =  $request->has('ios_app');
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->keywords = $request->keywords;
        if ($category->id == $request->parent_id) {
            throw ValidationException::withMessages([
                'parent_id' => 'Parent category cannot be the same category'
            ])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category->parent_id = $request->parent_id;
        $category->save();

        if ($request->image) {
            $category->updateIcon($request->image);
        }
        if ($request->cover_image) {
            $category->updateCoverImage($request->cover_image);
        }

        $this->forgetCache();
        return $this->jsonResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->checkPermission('category_delete');
        if (count($category->subcategories)) {
            foreach ($category->subcategories as $subcategory) {
                $subcategory->forceFill([
                    'parent_id' => null
                ])->save();
            }
        }

        $category->delete();

        $this->forgetCache();
        return $this->jsonResponse();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyParent(Category $category): JsonResponse
    {
        $this->checkPermission('category_edit');
        $category->parent_id = null;
        $category->forceFill([
            'parent_id' => null
        ])->save();
        return $this->jsonResponse();
    }


    private function forgetCache()
    {
        Cache::forget(Category::CACHE_KEY);
        Cache::forget(Category::POS_CACHE_KEY);
        Cache::forget(Category::ANDROID_APP_CACHE_KEY);
        Cache::forget(Category::IOS_APP_CACHE_KEY);
        Cache::forget(Item::DISCOUNT_ITEMS_CACHE_KEY);
        Cache::forget(Item::LATEST_ITEMS_CACHE_KEY);
        Cache::forget(Item::RANDOM_ITEMS_CACHE_KEY);
        Cache::forget(Category::CATALOG_CACHE_KEY);
    }
}
