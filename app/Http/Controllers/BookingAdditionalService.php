<?php

namespace App\Http\Controllers;

use App\Repositories\AdditionalServiceRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Route;

class BookingAdditionalService extends Controller
{
    /**
     * @var ServiceRepository
     */
    private $services;
    /**
     * @var AdditionalServiceRepository
     */
    private $additionalServices;

    public function __construct(ServiceRepository $services, AdditionalServiceRepository $additionalServices)
    {
        $this->services = $services;
        $this->additionalServices = $additionalServices;
    }

    public function index($service_id)
    {
        $service = $this->services->find($service_id);
        $additionalServices = $this->additionalServices->hasMastersForService($service);

        if ($additionalServices->count() == 0) {
            return redirect()->route('booking.aservices.master.index', [
                Route::input('booking'),
                0
            ]);
        }

        return view('booking.additionalServices', [
            'additionalServices' => $additionalServices
        ]);
    }

    public function store(Request $request)
    {
        $additionalServices = 0;
        if (!is_null($request->input('additionalService'))) {
            $this->validate($request, [
                'additionalService.*' => 'integer',
            ]);

            $additionalServices = implode('-', $request->input('additionalService'));
        }

        return redirect()->route('booking.aservices.master.index', [
            Route::input('booking'),
            $additionalServices
        ]);
    }

}
