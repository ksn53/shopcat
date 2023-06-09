<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemsResource extends ResourceCollection
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
            'data' =>  ItemResource::collection($this->collection),
        ];
    }
    public function with($request)
    {
        return [
            'links'    => [
                'self' => route('indexApi'),
            ],
        ];
    }
}
