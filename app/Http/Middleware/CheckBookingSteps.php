<?php

namespace App\Http\Middleware;

use App\Models\Service;
use App\Repositories\AdditionalServiceRepository;
use App\Repositories\ServiceRepository;
use App\Services\BookingService;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CheckBookingSteps
{
    /**
     * @var ServiceRepository
     */
    private $services;
    /**
     * @var AdditionalServiceRepository
     */
    private $additionalService;

    public function __construct(ServiceRepository $services, AdditionalServiceRepository $additionalService)
    {
        $this->services = $services;
        $this->additionalService = $additionalService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route();

        /**
         * Check every step for existing models
         */

        try {
            /**
             * Service
             */
            if ($route->hasParameter('booking')) {
                $service = $this->services->find($route->getParameter('booking'));
                if (is_null($service)) {
                    throw new ModelNotFoundException();
                }
            }

            /**
             * Additional Services
             */
            if ($route->hasParameter('aservices')) {

                $additionalServicesIds = with( new BookingService)->getAdditionalServicesIdFromInput();

                if (is_null($additionalServicesIds)) {
                    throw new ModelNotFoundException();
                }
                
                if ($additionalServicesIds->count() > 1 || $additionalServicesIds->first() != 0) {
                    if ($service->additionalServices->whereIn('id', $additionalServicesIds->toArray())->count() !== $additionalServicesIds->count()) {
                        throw new ModelNotFoundException();
                    }
                }
            }

            /**
             * Master
             */
            if ($route->hasParameter('master')) {
                $masterId = $route->getParameter('master');
                if ($masterId > 0 && !$route->hasParameter('date')) {
                    // Пока ничего не нужно
                }
            }


        } catch (ModelNotFoundException $e) {
            return redirect('/')->withErrors(trans('booking.These_reservations_are_outdated_Try_again'));
        }

        return $next($request);
    }
}
