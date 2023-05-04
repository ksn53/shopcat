<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemsResource;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
    public function show(Item $item)
    {
        return view('item', compact('item'));
    }
    public function showApi(Item $item)
    {
        ItemResource::withoutWrapping();
        return new ItemResource($item);
    }
    public function indexApi()
    {
        return new ItemsResource(Item::all());
    }
}
