<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CartResource;
use App\Http\Resources\CartsResource;
//use App\Http\Resources\ItemsResource;
use App\Models\Cart;
use App\Models\CartItem;
//use App\Models\Order;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        return new CartsResource(Cart::all());
    }
    public function createCart()
    {
        if (Auth::guard('api')->check()) {
            $userID = auth('api')->user()->getKey();
        }
        return Cart::create([
            'key' => md5(uniqid(rand(), true)),
            'user_id' => isset($userID) ? $userID : null,
        ]);
    }
    public function store(Request $request)
    {
        if ($this->createCart()) {
            return response()->json([
                'Message' => 'Корзина создана',
                'cartKey' => $this->createCart()->key,
            ], 201);
        }
    }

    public function show(Cart $cart)
    {
        CartResource::withoutWrapping();
        return new CartResource($cart);
    }

    /**
     * @param Cart $cart
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * Удаляет корзину
     */
    public function destroy(Cart $cart)
    {
        if ($cart->delete()) {
            return response()->json(['Message' => 'Корзина удалена'], 201);
        }
        return response()->json(['Message' => 'Ошибка удаления корзины'], 201);
    }

    public function addItem(Cart $cart, Item $item, $quantity = 1)
    {
        $cartItem = CartItem::where(['cart_id' => $cart->getKey(), 'item_id' => $item->id])->first();
        if ($cartItem) {
            if ($quantity == 1) {
                $quantity = $cartItem->quantity++;
            } else {
                $cartItem->quantity = $quantity;
            }

            CartItem::where(['cart_id' => $cart->getKey(), 'item_id' => $item->id])->update(['quantity' => $quantity]);
        } else {
            CartItem::create(['cart_id' => $cart->getKey(), 'item_id' => $item->id, 'quantity' => $quantity]);
        }
        return true;
    }
    public function cartShow()
    {
        $cartKey = session()->get('cart');
        if(!$cartKey) {
            $cart = new Cart();
        } else {
            $cart = Cart::firstOrCreate([ 'key' => $cartKey ]);
        }
        $user = new \App\Models\User();
        if (Auth::check()){
            $user = Auth::user();
        }
        dump($cartKey);
        dump($cart->items()->get());
        return view('cart', compact('user', 'cart'));
    }
    public function addItemWeb(Item $item)
    {
        $cartKey = session()->get('cart');
        if(!$cartKey) {
            $cart = $this->createCart();
            //session()->put('cart', $cart->key);
        } else {
            $cart = Cart::firstOrCreate([ 'key' => $cart ]);
        }
        session()->put('cart', $cart->key);
        //dd(session()->get('cart'));
        if ($this->addItem($cart, $item)) {
            //dd($cart->items()->get());
            return redirect()->back()->with('success', 'Товар добавлен в корзину');
        }

        //return redirect()->back()->with('success', 'Товар добавлен в корзину');

    }

    public function addItemApi(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
            'itemId' => 'required',
            'quantity' => 'required|numeric|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');
        $itemId = $request->input('itemId');
        $quantity = $request->input('quantity');

        if ($cart->key == $cartKey) {
            try { $item = Item::findOrFail($itemId);} catch (ModelNotFoundException $e) {
                return response()->json([
                    'message' => 'Такого товара не существует.',
                ], 404);
            }

            $cartItem = CartItem::where(['cart_id' => $cart->getKey(), 'item_id' => $itemId])->first();
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                CartItem::where(['cart_id' => $cart->getKey(), 'item_id' => $itemId])->update(['quantity' => $quantity]);
            } else {
                CartItem::create(['cart_id' => $cart->getKey(), 'item_id' => $itemId, 'quantity' => $quantity]);
            }

            return response()->json(['message' => 'Товар добавлен в корзину'], 200);
        } else {
            return response()->json([
                'message' => 'Не совпадает CartKey',
            ], 400);
        }
    }

}
