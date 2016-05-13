<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdditionalService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdditionalServiceUserController extends Controller
{
    public function update(Request $request, $serviceId, $masterId, $additionalServiceId)
    {
        $this->validate($request, [
            'price' => 'required|integer',
            'duration' => 'required|integer'
        ]);

        $master = User::role('master')->findOrFail($masterId);
        $service = Service::findOrFail($serviceId);
        $additionalService = AdditionalService::findOrFail($additionalServiceId);

        // Find service and pivot
        $masterAdditionalService = $master->additionalServices()->find($additionalService->id);

        if (!is_null($masterAdditionalService)) {
            // Update
            $master->additionalServices()->updateExistingPivot($additionalService->id, $request->only(['price', 'duration']));
        } else {
            // Create
            $master->additionalServices()->attach($additionalService, $request->only(['price', 'duration']));
        }

        return redirect()->route('admin.services.users.edit', [$service->id, $master->id])->with('message', trans('admin_service_user.parameters_for_service_updated_successfully'));

    }

}
