<?php

namespace App\Http\Middleware;

use App\Entities\Procedure;
use App\Models\PaymentType;
use App\Models\Service;
use App\Models\User;
use App\Repositories\AdditionalServiceRepository;
use App\Repositories\ServiceRepository;
use App\Services\BookingService;
use Carbon\Carbon;
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
    /**
     * @var BookingService
     */
    private $bookingService;

    public function __construct(ServiceRepository $services, AdditionalServiceRepository $additionalService, BookingService $bookingService)
    {
        $this->services = $services;
        $this->additionalService = $additionalService;
        $this->bookingService = $bookingService;
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
                    if ($additionalServicesIds->count() > 1 && $additionalServicesIds->search(0)) {
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
                    $master = User::role('master')->find($masterId);

                    if (!$master) {
                        throw new ModelNotFoundException();
                    }
                }
                elseif ($masterId == 0 && $route->hasParameter('date')) {
                    throw new ModelNotFoundException();
                }
            }

            /**
             * Visit date
             */

            if ($route->hasParameter('date')) {
                try {
                    $date = Carbon::parse($route->getParameter('date'));
                } catch (\Exception $e) {
                    throw new ModelNotFoundException();
                }

                // Check date
                if ($date < Carbon::now()) {
                    throw new ModelNotFoundException();
                }

                // Check date employed

                $procedure = new Procedure($service);
                if (isset($additionalServicesIds) && $additionalServicesIds->count()) {
                    $procedure->setAdditionalServices(
                        $this->bookingService->getAdditionalServicesFromInput()
                    );
                }

                $master = User::find($masterId);

                if (!$this->bookingService->isVisitDateAvailable($master, $procedure, $date)) {
                    // Date is employed
                    return redirect('/')->withErrors(trans('booking.chosen_date_is_not_available_to_book'));
                }
            }

            /**
             * Payment type
             */
            if ($route->hasParameter('payment')) {
                if (!PaymentType::find($route->getParameter('payment'))) {
                    throw new ModelNotFoundException();
                }
            }

        } catch (ModelNotFoundException $e) {
            return redirect('/')->withErrors(trans('booking.these_reservations_are_outdated_try_again'));
        }

        return $next($request);
    }
}
