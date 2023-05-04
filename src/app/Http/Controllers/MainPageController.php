<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Category;

class MainPageController extends Controller
{
    public function index()
    {
        $items = Item::all();
        $parentCategories = Category::where('parent_id',0)->get();
        return view('items', compact('items', 'parentCategories'));
    }
}
