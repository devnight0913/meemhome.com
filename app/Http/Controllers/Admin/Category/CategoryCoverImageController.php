<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryCoverImageController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->checkPermission('category_delete');
        $category->deleteCoverImage();
        Cache::forget(Category::CACHE_KEY);
        return $this->jsonResponse();
    }
}
