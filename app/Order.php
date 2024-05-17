<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    protected $fillable = ['customer_name', 'order_value', 'process_id', 'order_id', 'order_status'];

    /**
     * Create a new order.
     *
     * @param array $request
     * @return \App\Order
     */
    public function createNewOrder(array $request): Order
    {
        $lastOrder = Order::orderBy('id', 'desc')->first();
        $nextId = $lastOrder ? $lastOrder->id + 1 : 1;
        $orderId = 'ORD-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $order = [
            'order_id' => $orderId,
            'customer_name' => $request['customer_name'],
            'order_value' => $request['order_value'],
            'process_id' => rand(1, 10),
            'order_status' => 'ORDERED'
        ];

        return Order::create($order);
    }

    /**
     * Get order details.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getOrderDetails()
    {
        return Order::select('id', 'order_id', 'customer_name', 'order_value', 'process_id', 'order_status')
            ->where(function ($query) {
                $query->where('order_status', 'ORDERED')
                    ->orWhere('order_status', 'FAILED');
            });
    }

    /**
     * Submit order data.
     *
     * @param \Illuminate\Support\Collection $orderData
     * @return void
     */
    public function submitOrderData($orderData): void
    {
        $client = new Client();

        foreach ($orderData as $order) {
            try {
                $response = $client->post('https://wibip.free.beeceptor.com/order', [
                    'json' => [
                        "Order_ID" => $order->order_id,
                        "Customer_Name" => $order->customer_name,
                        "Order_Value" => $order->process_id,
                        "Order_Date" => $order->created_at,
                        "Order_Status" => $order->status,
                        "Process_ID" => $order->process_id
                    ]
                ]);

                // Update order status
                $this->updateOrderStatus($order->id, 'SUBMITTED');

                $statusCode = $response->getStatusCode();
                $responseBody = $response->getBody()->getContents();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                // Revert order status to failed
                $this->updateOrderStatus($order->id, 'FAILED');
            }
        }
    }

    /**
     * Update order status.
     *
     * @param int $orderId
     * @param string $status
     * @return void
     */
    private function updateOrderStatus(int $orderId, string $status): void
    {
        Order::where('id', $orderId)->update(['order_status' => $status]);
    }
}
