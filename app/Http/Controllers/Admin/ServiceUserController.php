<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ServiceUserController extends Controller
{

    public function index($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $masters = User::role('master')->get();

        return view('admin.service.user.index', [
            'pageTitle' => trans('admin_service_user.link_service_users'),
            'service' => $service,
            'masters' => $masters
        ]);
    }

    
    public function edit($serviceId,$userId)
    {
        $master = User::role('master')->findOrFail($userId);

        /**
         * Service
         */
        $service = Service::findOrFail($serviceId);
        $serviceUser = $master->services()->find($service->id);

        if (!is_null($serviceUser)) {
            $serviceUser = $serviceUser->pivot;
        }

        /**
         * Additional Services
         */
        $additionalServices = $service->additionalServices;
        $additionalServicesUser = collect();

        if (!is_null($additionalServices) && $additionalServices->count()) {
            foreach ($additionalServices as $additionalService) {
                $additionalServicesUserPivot = $master->additionalServices()->find($additionalService->id);
                if (!is_null($additionalServicesUserPivot)) {
                    $additionalServicesUser->put($additionalService->id, $additionalServicesUserPivot->pivot);
                }
            }
        }


        return view('admin.service.user.edit', [
            'pageTitle' => trans('admin_service_user.setting_parameters_service_for_user'),
            'master' => $master,
            'service' => $service,
            'serviceUser' => $serviceUser,
            'additionalServices' => $additionalServices,
            'additionalServicesUser' => $additionalServicesUser
        ]);
    }


    public function update(Request $request, $serviceId, $masterId)
    {
        $this->validate($request, [
            'price' => 'required|integer',
            'duration' => 'required|integer'
        ]);

        $master = User::role('master')->findOrFail($masterId);
        $service = Service::findOrFail($serviceId);

        // Find service and pivot
        $masterService = $master->services()->find($service->id);

        if (!is_null($masterService)) {
            // Update
            $master->services()->updateExistingPivot($service->id, $request->only(['price', 'duration']));
        } else {
            // Create
            $master->services()->attach($service, $request->only(['price', 'duration']));
        }

        return redirect()->route('admin.services.users.edit', [$service->id, $master->id])->with('message', trans('admin_service_user.parameters_for_service_updated_successfully'));
    }

}
