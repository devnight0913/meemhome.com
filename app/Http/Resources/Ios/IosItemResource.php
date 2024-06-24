<?php

namespace App\Http\Resources\Ios;

use App\Http\Resources\AdditionalImage\AdditionalImageResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class IosItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image_url' =>  $this->image_path ? route('image.show', ['path' => $this->image_path]) : asset('images/webp/placeholder.webp'),
            'search_name' => $this->search_name,
            'wholesale_price' => $this->wholesale_base_price,
            'retail_price' => $this->retail_base_price,
            'super_dealer_price' => $this->super_dealer_base_price,
            'description' => $this->description,
            'barcode' => $this->barcode,
            'sku' => $this->sku,
            'code' => $this->code,
            'url' => $this->url,
            'has_discount' => $this->has_discount,
            'is_new' => $this->is_new,
            'is_popular' => $this->is_popular,
            'category_id' => $this->category_id,
            'additional_images' => new AdditionalImageResourceCollection($this->whenLoaded('additional_images')),
        ];
    }
}
