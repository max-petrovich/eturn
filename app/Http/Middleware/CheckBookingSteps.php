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

                $additionalServicesIds = with(new BookingService)->getAdditionalServicesIdFromInput();

                if (is_null($additionalServicesIds)) {
                    throw new ModelNotFoundException();
                }

                // Get additional services to service
                $serviceAdditionalServices = $service->additionalServices;

                if ($serviceAdditionalServices->count()) {
                    if ($additionalServicesIds->count() > 1 && $additionalServicesIds->contains(0)) {
                        throw new ModelNotFoundException();
                    }

                    /**
                     * Check for existing input service ids in real service additional services array
                     */

                    if (!$additionalServicesIds->contains(0) &&
                            $additionalServicesIds->intersect($serviceAdditionalServices->pluck('id'))->count() != $additionalServicesIds->count()) {
                        throw new ModelNotFoundException();
                    }
                } else {
                    app()->make('BookingSteps')->setNotActive('aservices');

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
