<?php

namespace App\Http\Resources;

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
            'type' => 'item',
            'id' => (string)$this->id,
            'slug' => (string)$this->slug,
            'attributes' => [
                'name' => $this->name,
                'photo' => $this->photo,
                'price' => $this->price,
                'category' => $this->category()->pluck('name')[0],
                'description' => $this->description,
                'info' => $this->info,
                'weight' => $this->weight,
            ],
            'links'         => [
                'self' => route('singleitem', ['item' => $this->slug]),
            ],
        ];
    }
}
