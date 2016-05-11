<?php

namespace App\Http\Controllers;

use App\Entities\Procedure;
use App\Models\ClosedDate;
use App\Models\User;
use App\Repositories\ServiceRepository;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Route;

class BookingVisitDate extends Controller
{

    /**
     * @var ServiceRepository
     */
    private $services;
    /**
     * @var BookingService
     */
    private $bookingService;

    public function __construct(BookingService $bookingService, ServiceRepository $services)
    {
        $this->services = $services;
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        return view('booking.visitDate',[
            'inputData' => [
                'service_id' => Route::input('booking'),
                'additionalServices' => Route::input('aservices'),
                'master_id' => Route::input('master')
            ]
        ]);
    }
}
