<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json(['products' => $products], 200);
    }

    public function create()
    {
        return response()->json(['message' => 'create method'], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($request->all());

        return response()->json(['product' => $product, 'message' => 'Ürün başarıyla eklendi.'], 201);
    }

    public function show(Product $product)
    {
        return response()->json(['product' => $product], 200);
    }

    public function edit(Product $product)
    {
        return response()->json(['product' => $product, 'message' => 'edit method'], 200);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $product->update($request->all());

        return response()->json(['product' => $product, 'message' => 'Ürün başarıyla güncellendi.'], 200);
    }
}
