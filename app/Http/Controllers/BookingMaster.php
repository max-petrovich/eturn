<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;

use Route;

class BookingMaster extends Controller
{
    /**
     * @var ServiceRepository
     */
    private $services;

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
        $masters = $this->services->find(Route::input('booking'))->users;

        // Add to masters collection new user with id = 0
        $masters->prepend(factory(\App\Models\User::class)
            ->make([
                'id' => 0,
                'fio' => trans('all.irrelevant')
            ]));

        return view('booking.master', [
            'masters' => $masters
        ]);
    }
    
}
