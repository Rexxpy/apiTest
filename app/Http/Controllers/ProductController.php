<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return new ProductResource(true, 'Product List', $products);

    }

    public function store(Request $request, Product $products)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $products = Product::create([
                    'id' => $products->id,
                    'name' => $request->name,
                    'price' => $request->price,
                    'stock' => $request->stock,
                    'sold' => 0,
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => [
                'id' => $products->id, // Menampilkan ID produk di atas
                'name' => $products->name,
                'price' => $products->price,
                'stock' => $products->stock,
                'sold' => $products->sold,
                'created_at' => $products->created_at,
                'updated_at' => $products->updated_at,
            ]
        ]);
    }

    public function show($id)
    {
        $products = Product::find($id);
        return new ProductResource(true, $products ? 'Product Detail' : 'Product not found', $products);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed$products
     * @return void
     */
    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $products = Product::find($id);

        $products->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return new ProductResource(true, 'Product successfully updated', $products);
    
    }

    public function destroy($id)
    {
       $products = Product::find($id);

       if (!$products) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

       $products->delete();

        return new ProductResource(true, 'Product successfully delete', $products);
    }

    
}
