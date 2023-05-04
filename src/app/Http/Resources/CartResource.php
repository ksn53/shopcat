<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'type' => 'cart',
            'id' => (string)$this->id,
            'key' => (string)$this->key,
            'attributes' => [
                'user_id' => $this->name,
                'items' => $this->items()->get(),
            ],
        ];
    }
}
