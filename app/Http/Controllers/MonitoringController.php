<?php

namespace App\Http\Controllers;

use App\Services\MonitoringService;
use Illuminate\Http\Request;

use App\Http\Requests;

class MonitoringController extends Controller
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

        return view('monitoring', [
            'pageTitle' => trans('all.monitoring'),
            'orders' => $this->monitoringService->getOrders()
        ]);
    }
}
