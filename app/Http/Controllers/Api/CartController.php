<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cart->load('items.product');
        return response()->json($cart);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $item = $cart->items()->where('product_id', $request->product_id)->first();
        if ($item) {
            $item->quantity += $request->quantity;
            $item->save();
        } else {
            $item = $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        return response()->json($item, 201);
    }

public function update(Request $request, $item_id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    // تأكد من وجود سلة للمستخدم
    $cart = Cart::firstOrCreate(['user_id' => $user->id]);

    // جلب العنصر من السلة
    $item = $cart->items()->find($item_id);

    if (!$item) {
        return response()->json(['error' => 'Item not found in cart'], 404);
    }

    // تعديل الكمية
    $item->quantity = $request->quantity;
    $item->save();

    return response()->json($item);
}

    public function remove($item_id)
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $item = $cart->items()->findOrFail($item_id);
        $item->delete();
        return response()->json(['message' => 'Item removed from cart']);
    }
}
