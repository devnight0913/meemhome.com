<?php

namespace App\Http\Controllers\Admin\Item;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\JsonResponse;


class ItemAdditionalImageController extends Controller
{
    /**
     * Delete item image from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Image $image): JsonResponse
    {
        $image->removeFromStorage();
        $image->delete();
        return $this->jsonResponse();
    }
}
