<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{

    public function index()
    {
        $services = Service::orderBy('title')->get();
        
        return view('admin.service.index', [
            'pageTitle' => trans('admin.services'),
            'services' => $services
        ]);
    }

    public function create()
    {
        return view('admin.service.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);
        
        Service::create(['title' => $request->input('title')]);

        return redirect()->route('admin.services.index')->with('message', trans('admin_services.service_added'));
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $additionalServices = $service->additionalServices;

        return view('admin.service.edit',[
            'pageTitle' => trans('all.editing'),
            'service' => $service,
            'additionalServices' => $additionalServices
        ]);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);
        
        $service = Service::findOrFail($id);
        $service->title = $request->input('title');
        $service->save();

        return redirect()->route('admin.services.index')->with('message', trans('admin_services.service_edited'));
    }

    
}
