<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getRouteKeyName()
    {
        return 'key';
    }
    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function total()
    {
        $items = $this->items()->get();
        $total = 0;
        foreach ($items as $item) {
            $price = $item->price * $item->pivot->quantity;
            $total += $price;
        }
        return $total;
    }
    public function itemsCount()
    {
        $items = $this->items()->get();
        $total = 0;
        foreach ($items as $item) {
            //$price = $item->price * $item->pivot->quantity;
            $total += $item->pivot->quantity;
        }
        return $total;
    }
    public function hasItem($slug)
    {
        if ($this->items->contains('slug', $slug)) {
            return true;
        }
        return false;
    }
}
