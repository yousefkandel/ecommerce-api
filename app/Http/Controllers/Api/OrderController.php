<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * إنشاء طلب من السلة
     */
    public function createFromCart()
    {
        $user = Auth::user();

        // جلب السلة
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        if ($cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        // حساب المجموع
        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->quantity * $item->product->price;
        }

        // إنشاء الطلب
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $total,
            'status' => 'pending',
        ]);

        // إنشاء عناصر الطلب
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // مسح السلة بعد تحويلها لطلب
        $cart->items()->delete();

        return response()->json($order->load('items.product'));
    }

    /**
     * عرض جميع الطلبات للمستخدم (بدون استخدام $user->orders())
     */
    public function index()
    {
        $user = Auth::user();

        // جلب الطلبات مباشرة من جدول orders
        $orders = Order::with('items.product')
            ->where('user_id', $user->id)
            ->get();

        return response()->json($orders);
    }

    /**
     * عرض تفاصيل طلب معين (بدون استخدام $user->orders())
     */
    public function show($order_id)
    {
        $user = Auth::user();

        $order = Order::with('items.product')
            ->where('user_id', $user->id)
            ->findOrFail($order_id);

        return response()->json($order);
    }
}
