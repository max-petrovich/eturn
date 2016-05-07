<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Repositories\AdditionalServiceRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

class BookingController extends Controller
{

    /**
     * The service repository instance
     */
    private $services;

    /**
     * BookingController constructor.
     * @param ServiceRepository $services
     */
    public function __construct(ServiceRepository $services)
    {
        $this->services = $services;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('booking.services', [
           'services' => $this->services->hasMasters()
       ]);
    }

}
