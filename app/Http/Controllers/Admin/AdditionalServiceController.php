<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdditionalService;
use App\Models\Service;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdditionalServiceController extends Controller
{

    protected $rules = [
        'title' => 'required'
    ];
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        return view('admin.additionalServices.create',[
            'pageTitle' => trans('admin_additionalServices.adding_additional_service'),
            'service' => $service
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $serviceId)
    {
        $this->validate($request, $this->rules);

        $service = Service::findOrFail($serviceId);
        $additionalSerivce = new AdditionalService();

        $additionalSerivce->fill($request->all());
        $additionalSerivce->service()->associate($service);
        
        $additionalSerivce->save();

        return redirect()->route('admin.services.edit', $service->id)->with('message', trans('admin_additionalServices.additional_service_success_added'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($serviceId, $additionalSerivceId)
    {
        $service = Service::findOrFail($serviceId);
        $additionalSerivce = $service->additionalServices()->findOrFail($additionalSerivceId);

        return view('admin.additionalServices.edit',[
            'pageTitle' => trans('admin_additionalServices.editing_additional_serivce'),
            'service' => $service,
            'additionalSerivce' => $additionalSerivce
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $serviceId, $additionalSerivceId)
    {
        $this->validate($request, $this->rules);

        $service = Service::findOrFail($serviceId);
        $additionalSerivce = $service->additionalServices()->findOrFail($additionalSerivceId);

        $additionalSerivce->fill($request->all());

        $additionalSerivce->save();

        return redirect()->route('admin.services.edit', $service->id)->with('message', trans('admin_additionalServices.additional_service_success_edited'));
    }

}
