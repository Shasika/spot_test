<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Create a new order.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewOrder(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string',
            'order_value' => 'required|numeric',
        ]);

        $order = new Order();
        $createdOrder = $order->createNewOrder($validatedData);

        return response()->json([
            'order_id' => $createdOrder->order_id,
            'process_id' => $createdOrder->process_id,
            'order_status' => $createdOrder->order_status,
            'message' => 'Order created successfully',
        ], 201);
    }
}
