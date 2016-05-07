<?php

namespace App\Http\Controllers;

use App\Entities\Procedure;
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
        /**
         * Create procedure entity
         */
        $service = $this->services->find(Route::input('booking'));
        $procedure = new Procedure($service);

        $additionalServicesId = $this->bookingService->getAdditionalServicesIdFromInput();
        if (!$additionalServicesId->contains(0)) {
            $additionalServices = $service->additionalServices->whereIn('id', $additionalServicesId->toArray());

            $procedure->setAdditionalServices($additionalServices);
        }

        if (Route::input('master') != 0) {
            $master = User::find(Route::input('master'));

            // TODO API check date
            // Check date
            try {
                $dateInput = Carbon::parse('08-05-2016');
            } catch (\Exception $e) {
                // TODO in api return error
            }

            $freeIntervals = $this->bookingService->getFreeIntervalsForMaster($master, $procedure, $dateInput);
            dd($freeIntervals);
        }



        return view('booking.visitDate');
    }
}
