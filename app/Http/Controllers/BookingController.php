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

    public function __construct(ServiceRepository $services)
    {
        $this->services = $services;
    }
    
    public function index()
    {
       return view('booking.services', [
           'services' => $this->services->hasMasters()
       ]);
    }

}
