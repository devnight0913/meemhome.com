<?php

namespace App\Http\Resources\Pos;

use Illuminate\Http\Resources\Json\JsonResource;

class PosCategoryResource extends JsonResource
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
            'sort_order' => $this->sort_order,
            'url' => $this->url,
            'items' => new PosItemResourceCollection($this->items),
        ];
    }
}