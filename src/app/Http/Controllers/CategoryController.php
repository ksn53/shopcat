<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Http\Resources\CategorysResource;

class CategoryController extends Controller
{
    public function index(Category $category)
    {
        $items = $category->items()->get();
        $parentCategories = Category::where('parent_id',0)->get();
        return view('items', compact('items', 'parentCategories'));
    }
    public function treeApi()
    {
        return new CategorysResource(Category::where('parent_id',0)->get());
    }
}
