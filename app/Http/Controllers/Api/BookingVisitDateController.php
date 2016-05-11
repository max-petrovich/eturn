<?php

namespace App\Http\Controllers\Api;

use App\Entities\Procedure;
use App\Models\Service;
use App\Models\User;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class BookingVisitDateController extends ApiController
{

    /**
     * @var BookingService
     */
    private $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }
    /**
     * @param $date
     * @param $masterId
     * @param $serviceId
     * @param null $additionalServicesIds
     * @return Collection
     */
    public function getAvailableIntervals($date, $masterId, $serviceId, $additionalServicesIds)
    {
        /**
         * Check input data
         */

        // Date
        try {
            $date = Carbon::parse($date);
        } catch (\Exception $e) {
            return $this->respondBadRequest('Date has incorrect format');
        }

        /**
         * Check date valid
         */
        if ($date < Carbon::today()) {
            return $this->respondBadRequest('Date outdated');
        }

        // Service
        $service = Service::find($serviceId);

        if (is_null($service)) {
            return $this->respondNotFound('Service not found');
        }

        // Master (or masters)
        if ($masterId == 0) {
            // Select all masters for this service
            $masters = User::role('master')->whereHas('services', function ($q) use($service) {
                $q->whereServiceId($service->id);
            })->get();

            if ($masters->count() == 0) {
                return $this->respondNotFound('Masters not found');
            }
        } else {
            $masters = collect([User::find($masterId)]);

            if (is_null($masters->first()) || !$masters->first()->hasRole('master')) {
                return $this->respondNotFound('Master not found');
            }
        }


        if ($masterId != 0 ) {
            /* Check service belong */
            $masterService = $masters->first()->services()->find($service->id);
            if (is_null($masterService)) {
                return $this->respondBadRequest("Service doesn't belong to the master");
            }
        }


        // Additional services
        if (!is_null($additionalServicesIds)) {
            $additionalServicesIdCollection = with(new BookingService())->getAdditionalServicesIdFromInput('additionalServicesIds');
            if (is_null($additionalServicesIdCollection)) {
                return $this->respondBadRequest('Additional services has invalid format');
            }
            if (!$additionalServicesIdCollection->contains(0)) {
                $additionalServices = $service->additionalServices->whereIn('id', $additionalServicesIdCollection->toArray());
            }
        }

        /**
         * Create procedure entity
         */
        $procedure = new Procedure($service);

        if (isset($additionalServices)) {
            $procedure->setAdditionalServices($additionalServices);
        }

        $availableIntervals = $this->bookingService->getAvailableIntervals($masters, $procedure, $date);

        if (is_null($availableIntervals) || ($availableIntervals instanceof Collection && $availableIntervals->isEmpty())) {
            return $this->respondNotFound('Intervals not found');
        } else {
            return $this->respond(fractal()->collection($availableIntervals, function ($availableInterval){
                $transformedIntervals = [];
                foreach ($availableInterval['intervals'] as $interval) {
                    $transformedIntervals[] = [
                        Carbon::parse($interval[0])->format('H:i'),
                        Carbon::parse($interval[1])->format('H:i'),
                    ];
                }
                return [
                    'master' => [
                        'id' => $availableInterval['master']->id,
                        'fio' => $availableInterval['master']->fio,
                        'photo' => $availableInterval['master']->photoLink
                    ],
                    'price' => $availableInterval['price'],
                    'intervals' => $transformedIntervals,
                ];
            }));
        }


    }

}
