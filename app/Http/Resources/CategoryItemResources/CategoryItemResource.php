<?php

namespace App\Http\Resources\CategoryItemResources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'image_url' => $this->image_url,
            'slug' => $this->slug,
            'sort_order' => $this->sort_order,
            'items' => new ItemResourceCollection($this->items),
            'url' => $this->url,
        ];
    }
}
