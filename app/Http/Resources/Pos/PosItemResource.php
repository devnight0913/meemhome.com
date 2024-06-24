<?php

namespace App\Http\Resources\Pos;

use Illuminate\Http\Resources\Json\JsonResource;

class PosItemResource extends JsonResource
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
            'cost' => $this->cost,
            'description' => $this->description,
            'barcode' => $this->barcode,
            'sku' => $this->sku,
            'code' => $this->code,
            'url' => $this->url,
            'in_stock' => $this->in_stock,
            'track_stock' => $this->track_stock,
            'continue_selling_when_out_of_stock' => $this->continue_selling_when_out_of_stock,
            'category_id' => $this->category_id,
        ];
    }
}
