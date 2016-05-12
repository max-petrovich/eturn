<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MonitoringController extends Controller
{
    public function get(Request $request)
    {
        $orders = Order::eagerLoadAll()->get();

        $response = fractal()->collection($orders, new OrderTransformer());

        return $response;
    }
}
