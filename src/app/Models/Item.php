<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function orders()
    {
        return $this->morphedByMany(Order::class, 'orderable');;
    }
}
