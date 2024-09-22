<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with('products')->get();

        $response = [
            'message' => 'Order List',
            'data' => []
        ];

        foreach ($orders as $order) {
            $orderData = [
                'id' => $order->id,
                'products' => []
            ];

            foreach ($order->products as $product) {
                $orderData['products'][] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->pivot->quantity,
                    'stock' => $product->stock,
                    'sold' => $product->sold,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ];
            }

            $orderData['created_at'] = $order->created_at;
            $orderData['updated_at'] = $order->updated_at;

            $response['data'][] = $orderData;
        }

        return response()->json($response, 200);        
    }

    public function store(Request $request)
    {
        $orders = Order::create();
        $products = $request->products;

        foreach ($products as $product) {
            $productModel = Product::find($product['id']);
            $productModel->update([
                'stock' => $productModel->stock - $product['quantity'],
                'sold' => $productModel->sold + $product['quantity']
            ]);

            $orders->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return new OrderResource(true, 'Order created successfully', $orders->load('products'));
    }

    public function show($id)
    { 
        $orders = Order::with('products')->find($id);

        if (!$orders) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        return new OrderResource(true, 'Order Detail', $orders);
    }

    public function destroy($id)
    {
        $orders = Order::find($id);

        if (!$orders) {
         return response()->json([
             'message' => 'Orders not found'
         ], 404);
     }
 
        $orders->delete();
 
         return new OrderResource(true, 'Orders successfully delete', $orders);
    }
}
