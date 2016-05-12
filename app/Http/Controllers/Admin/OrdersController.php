<?php

namespace App\Http\Controllers\Admin;

use App\Services\MonitoringService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{

    /**
     * @var MonitoringService
     */
    private $monitoringService;

    public function __construct(MonitoringService $monitoringService)
    {
        $this->monitoringService = $monitoringService;
    }

    public function index()
    {
        return view('admin.orders', [
            'pageTitle' => trans('admin.orders_list'),
            'orders' => $this->monitoringService->getOrders()
        ]);
    }
}
