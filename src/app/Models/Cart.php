<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['id','key','user_id'];
    //public $incrementing = false;
    public function getRouteKeyName()
    {
        return 'key';
    }
    public function items() {
        return $this->hasMany(CartItem::class, 'cart_id');
    }
    public function itemsGet()
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }
    public function total()
    {
        $items = $this->items()->get();
        $total = 0;
        foreach ($items as $item) {
            $price = $item->price * $item->quantity;
            $total += $price;
        }
        return $total;
    }
    public function extractItemIds()
    {
        $items = $this->items()->get();
        foreach ($items as $item) {
            $output[$item->item_id] = ['quantity' => $item->quantity];
        }
        return $output;
    }
    public function hasItem($slug)
    {
        if ($this->items->contains('slug', $slug)) {
            return true;
        }
        return false;
    }
}
