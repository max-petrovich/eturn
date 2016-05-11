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
