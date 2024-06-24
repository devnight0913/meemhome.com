<?php

namespace App\Http\Resources\CategoryItemResources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'search_name' => $this->search_name,
            'slug' => $this->slug,
            'base_price' => $this->base_price,
            'view_original_price' => $this->view_original_price,
            'view_price' => $this->view_price,
            'has_discount' => $this->has_discount,
            'is_new' => $this->is_new,
            'des' => $this->des,
            'preview_des' => $this->preview_des,
            'is_popular' => $this->is_popular,
            'url' => $this->url,
            'category_name' => $this->category_name,
        ];
    }
}
