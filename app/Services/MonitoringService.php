<?php namespace App\Services;

use App\Models\Order;
use App\Transformers\OrderTransformer;

class MonitoringService
{

    /**
     * Get orders
     * @return \Illuminate\Support\Collection
     */
    public function getOrders()
    {
        $orders = Order::eagerLoadAll()->orderBy('visit_start')->get();

        if ($orders->count()) {
            $transformedOrders = fractal()->collection($orders, new OrderTransformer())->toArray()['data'];
            return collect($transformedOrders);
        }
    }
}