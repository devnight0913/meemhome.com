<?php

namespace App\Http\Controllers\Admin\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequests\ItemStoreRequest;
use App\Http\Requests\ItemRequests\ItemUpdateRequest;
use App\Http\Resources\ItemResources\ItemResourceCollection;
use App\Models\Category;
use App\Models\Image;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{

    const RANDOM_STRING_LENGTH = 4;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $this->checkPermission('product_access');
        return $this->jsonResponse(['data' => new ItemResourceCollection(
            Item::with('category', 'additional_images')->orderBy('name', 'ASC')->get()
        )]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ItemRequests\ItemStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ItemStoreRequest $request): JsonResponse
    {

        $this->checkPermission('product_create');
        $item = new Item();
        $item->name = $request->name;
        $item->description = $request->description;
        $item->category_id = $request->category;

        $item->status_id = $request->status;
        $item->pos =  $request->has('pos');
        $item->website =  $request->has('website');
        $item->android_app =  $request->has('android_app');
        $item->ios_app =  $request->has('ios_app');

        $item->price = $request->price;
        $item->discount = $request->discount;
        $item->cost = $request->cost;


        $item->sku = $request->sku;
        $item->barcode = $request->barcode;
        $item->code = $request->code;
        // $item->serial_number = $request->serial_number;
        // $item->warranty_period = $request->warranty_period ?? 0;

        // $item->continue_selling_when_out_of_stock =  $request->has('continue_selling_when_out_of_stock');
        // $item->track_stock = $request->has('track_stock');
        
        $item->in_stock = $request->in_stock ?? 0;
        $item->continue_selling_when_out_of_stock =  true;
        $item->track_stock = false;


        $item->meta_title = $request->meta_title;
        $item->meta_description = $request->meta_description;
        $item->keywords = $request->keywords;
        if ($request->data_sheet) {
            $item->data_sheet_path = $request->data_sheet->storePublicly('data-sheets', 'public');
        }

        $item->save();



        if ($request->image) {
            $item->updateImage($request->image);
        }

        if ($request->additional_images) {
            foreach ($request->additional_images as $additional_image) {
                $image = new Image();
                $image->image_path = $additional_image->store('item-image');
                $image->item_id = $item->id;
                $image->save();
            }
        }


        $this->forgetCategoryCache();
        // Cache::forget(Item::SIMILAR_ITEMS_CACHE_KEY);
        return $this->jsonResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ItemRequests\ItemUpdateRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ItemUpdateRequest $request, Item $item): JsonResponse
    {
        $this->checkPermission('product_edit');
        $item->name = $request->name;
        $item->description = $request->description;
        $item->category_id = $request->category;

        $item->status_id = $request->status;
        $item->pos =  $request->has('pos');
        $item->website =  $request->has('website');
        $item->android_app =  $request->has('android_app');
        $item->ios_app =  $request->has('ios_app');

        $item->price = $request->price;
        $item->discount = $request->discount;
        $item->cost = $request->cost;


        $item->sku = $request->sku;
        $item->barcode = $request->barcode;
        $item->code = $request->code;
        $item->in_stock = $request->in_stock;
        // $item->serial_number = $request->serial_number;
        // $item->warranty_period = $request->warranty_period ?? 0;

        // $item->continue_selling_when_out_of_stock =  $request->has('continue_selling_when_out_of_stock');
        // $item->track_stock =  $request->has('track_stock');


        $item->meta_title = $request->meta_title;
        $item->meta_description = $request->meta_description;
        $item->keywords = $request->keywords;
        if ($request->data_sheet) {
            $item->data_sheet_path = $request->data_sheet->storePublicly('data-sheets', 'public');
        }

        $item->save();

        if ($request->image) {
            $item->updateImage($request->image);
        }

        if ($request->additional_images) {
            foreach ($request->additional_images as $additional_image) {
                $image = new Image();
                $image->image_path = $additional_image->store('item-image');
                $image->item_id = $item->id;
                $image->save();
            }
        }
        $this->forgetCategoryCache();
        Cache::forget($item->cache_key);
        // Cache::forget(Item::SIMILAR_ITEMS_CACHE_KEY);

        return $this->jsonResponse(['data' => $item->load('category', 'additional_images')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Item $item): JsonResponse
    {
        $this->checkPermission('product_delete');
        Cache::forget($item->cache_key);
        // Cache::forget(Item::SIMILAR_ITEMS_CACHE_KEY);
        //$item->deleteImage();
        $item->delete();
        $this->forgetCategoryCache();
        return $this->jsonResponse();
    }


    /**
     * Replicate the specified resource in storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function replicate(Item $item): JsonResponse
    {
        $this->checkPermission('product_create');
        $newItem = $item->replicate();
        if ($item->image_path) {
            $fileExtension = File::extension(Storage::path($item->image_path));
            $newName = Str::random(40) . '.' . $fileExtension;
            $newPathWithName = "item-image/{$newName}";
            File::copy(Storage::path($item->image_path), Storage::path($newPathWithName));
            $newItem->image_path = $newPathWithName;
        }
        $newItem->sku = null;
        $newItem->barcode = null;
        $newItem->code = null;
        $newItem->views = 0;
        $newItem->save();
        $this->forgetCategoryCache();
        // Cache::forget(Item::SIMILAR_ITEMS_CACHE_KEY);
        return $this->jsonResponse();
    }

    private function forgetCategoryCache()
    {
        Cache::forget(Category::CACHE_KEY);
        Cache::forget(Category::POS_CACHE_KEY);
        Cache::forget(Category::ANDROID_APP_CACHE_KEY);
        Cache::forget(Category::IOS_APP_CACHE_KEY);
        Cache::forget(Item::LATEST_ITEMS_CACHE_KEY);
        Cache::forget(Item::DISCOUNT_ITEMS_CACHE_KEY);
        Cache::forget(Item::RANDOM_ITEMS_CACHE_KEY);
        Cache::forget("catalog");
    }
}
