<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // عرض كل المنتجات
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return response()->json($products);
    }

    // إنشاء منتج جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    // عرض منتج واحد
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    // تحديث منتج
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($request->all());
        return response()->json($product);
    }

    // حذف منتج
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}
