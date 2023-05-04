<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ApiItemsController extends Controller
{
    //Можно сделать с помощью Eloquent filter но времени нет.
    //По этому всё по-простому.
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => ['sometimes', 'numeric'],
            'minprice' => ['sometimes', 'numeric'],
            'maxprice' => ['sometimes', 'numeric'],
            'maxweight' => ['sometimes', 'numeric'],
            'minweight' => ['sometimes', 'numeric'],

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $query = DB::table('items');

        if ($request->filled('category')) {
            $query->where('category_id', $request->get('category'));
        }
        if ($request->filled('maxprice')) {
            $query->where('price', '<', $request->get('maxprice'));
        }
        if ($request->filled('minprice')) {
            $query->where('price', '>', $request->get('minprice'));
        }
        if ($request->filled('maxweight')) {
            $query->where('weight', '<', $request->get('maxweight'));
        }
        if ($request->filled('minweight')) {
            $query->where('weight', '>', $request->get('minweight'));
        }
        $output = $query->get();
        return response()->json(['data' => $output], 200);
    }
}
