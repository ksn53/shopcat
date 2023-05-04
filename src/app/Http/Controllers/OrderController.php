<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OrderRequestValidate;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersResource;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return view('orders', compact('orders'));
    }
    public function currentOrderShow()
    {
        $key = session()->get('key');
        if(!$key) {
            $order = new Order();
        } else {
            $order = Order::firstOrCreate([ 'key' => $key ]);
        }
        $user = new \App\Models\User();
        if (Auth::check()){
            $user = Auth::user();
        }
        return view('cart', compact('user', 'order'));
    }
    public function showApi(Order $order)
    {
        OrderResource::withoutWrapping();
        return new OrderResource($order);
    }
    public function indexApi()
    {
        return new OrdersResource(Order::all());
    }

    public function store(Order $order, OrderRequestValidate $request)
    {
        $data = $request->validated();
        $data['user_id'] = 2;
        if (Auth::check()){
            $data['name'] = Auth::user()->name;
            $data['email'] = Auth::user()->email;
            $data['phone'] = Auth::user()->phone;
            $data['user_id'] = Auth::user()->id;
        }
        $order->update(['name' => $data['name'], 'email' => $data['email'], 'phone' => $data['phone'], 'user_id' => $data['user_id'], 'processed' => true]);
        session()->forget('key');
        return redirect(route('orderslist'));
    }
    public function storeApi(Cart $cart, OrderRequestValidate $request)
    {
        $data = $request->validated();
        $data['user_id'] = 2;
        if (Auth::check()){
            $data['name'] = Auth::user()->name;
            $data['email'] = Auth::user()->email;
            $data['phone'] = Auth::user()->phone;
            $data['user_id'] = Auth::user()->id;
        }
        $order = Order::create($data);

        if ($order->items()->sync($cart->extractItemIds())) {
            $cart->delete();
        }
        return response()->json([
            'Message' => 'Заказ создан',

        ], 201);
    }

    private function extractItemIds($items)
    {
        foreach ($items as $key => $value) {
            $output[$key] = ['quantity' => $value['quantity']];
        }
        return $output;
    }

    public function show(Order $order)
    {
        return view('order', compact('order'));
    }
    public function delItem(Order $order, Item $item)
    {
        if ($order->hasItem($item->slug)) {
            $order->items()->detach($item->id);
            return true;
        }
        return false;
    }
    public function removeFromCartWeb(Item $item)
    {
        $key = session()->get('key');
        if($key) {
            $order = Order::firstOrCreate([ 'key' => $key ]);
            if ($this->delItem($order, $item)) {
                return redirect()->back()->with('success', 'Товар удалён из корзины.');
            }
        }
    }
    public function updateCart(Item $item, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }
        $quantity = $request->input('quantity');

        $key = session()->get('key');
        if($key) {
            $order = Order::firstOrCreate([ 'key' => $key ]);
            if ($this->setQuantity($order, $item, $quantity)) {
                return redirect()->back()->with('success', 'Количество товара обновлено.');
            }
        }
    }
    public function addItem(Order $order, Item $item, $quantity = 1)
    {
        if ($order->hasItem($item->slug)) {
            $oldQuantity = $order->items()->where('slug', $item->slug)->first()->pivot->quantity;
            $quantity = $oldQuantity + 1;
            $this->setQuantity($order, $item, $quantity);
            //DB::table('item_order')->where(['order_id' => $order->id, 'item_id' => $item->id])->update(['quantity' => $quantity]);
        } else {
            $order->items()->attach([$item->id => ['quantity' => $quantity]]);
        }
        return true;
    }
    public function setQuantity(Order $order, Item $item, $quantity = 1)
    {
        if ($order->hasItem($item->slug)) {
            DB::table('item_order')->where(['order_id' => $order->id, 'item_id' => $item->id])->update(['quantity' => $quantity]);
            return true;
        }
        return false;
    }
    public static function returnCurrentOrder()
    {
        $key = session()->get('key');
        if(!$key) {
            $order = new Order();
        } else {
            $order = Order::firstOrCreate([ 'key' => $key ]);
        }
        return $order;
    }
    public function addItemWeb(Item $item)
    {
        $key = session()->get('key');
        if(!$key) {
            $order = $this->createOrder();
        } else {
            $order = Order::firstOrCreate([ 'key' => $key ]);
        }
        session()->put('key', $order->key);
        if ($this->addItem($order, $item)) {
            return redirect()->back()->with('success', 'Товар добавлен в корзину');
        }
    }
    public function createOrder()
    {
        if (Auth::guard('api')->check()) {
            $userID = auth('api')->user()->getKey();
        }
        return Order::create([
            'key' => md5(uniqid(rand(), true)),
            'user_id' => isset($userID) ? $userID : null,
        ]);
    }
}
