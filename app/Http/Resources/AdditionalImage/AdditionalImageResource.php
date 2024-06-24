<?php

namespace App\Http\Resources\AdditionalImage;

use Illuminate\Http\Resources\Json\JsonResource;

class AdditionalImageResource extends JsonResource
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
            'image_url' => route('image.show', ['path' => $this->image_path]),
        ];;
    }
}
