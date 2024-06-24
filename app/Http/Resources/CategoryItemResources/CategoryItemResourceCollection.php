<?php

namespace App\Http\Resources\CategoryItemResources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryItemResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
