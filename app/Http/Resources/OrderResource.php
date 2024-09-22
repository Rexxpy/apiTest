<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public $status;
    public $message;

    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource);
        $this->status  = $status;
        $this->message = $message;
    }

    public function toArray($request)
    {
        if ($this->resource === null) {
            return [
                'message' => 'Order not found',
            ];
        }

        return [
            'message' => $this->message,
            'data' => [
                'id' => $this->id,
                'products' => $this->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $product->pivot->quantity,
                        'stock' => $product->stock,
                        'sold' => $product->sold,
                        'created_at' => $product->created_at,
                        'updated_at' => $product->updated_at,
                    ];
                }),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
