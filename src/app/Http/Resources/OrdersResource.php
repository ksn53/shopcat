<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrdersResource extends ResourceCollection
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
            'data' =>  OrderResource::collection($this->collection),
        ];
    }
    public function with($request)
    {
        return [
            'links'    => [
                'self' => route('indexOrderApi'),
            ],
        ];
    }
}
