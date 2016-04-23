<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

use App\Http\Requests;

class MainController extends Controller
{

    public function index()
    {
        $services_list = Service::orderBy('title')->get();

        return view('welcome')->with([
            'services' => $services_list
        ]);
    }
}
