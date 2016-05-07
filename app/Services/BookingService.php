<?php namespace App\Services;

use App\Entities\Procedure;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Request;

class BookingService
{

    /**
     * Get free intervals to master a certain date
     * @param $master \App\Models\User
     * @param $procedure \App\Entities\Procedure
     * @param $date string
     * @return array
     */
    public function getFreeIntervalsForMaster(User $master, Procedure $procedure, Carbon $date)
    {
        /**
         * Check date in closed days
         */

        $procedureDuration = $procedure->getDurationForMaster($master);

    }

    /**
     * Get free intervals for all masters on a certain date
     * @param $date string
     * @param $service \App\Models\Service
     * @param $additionalServices \App\Models\AdditionalService
     * @return array
     */
    public function getFreeIntervals()
    {
        
    }

    /**
     * Check the choice of booking time on a certain date
     * @param $date string
     * @param $time string
     */


    /**
     * Get additional services id-s from Input
     * @param string $paramName
     * @param string $idDelimeter
     * @return null | Collection
     */
    public function getAdditionalServicesIdFromInput($paramName = 'aservices', $idDelimeter = '-')
    {
        $route = Request::route();

        $additionalServicesStr = $route->getParameter($paramName);

        if (!preg_match('#^[0-9'.$idDelimeter.']+$#s', $additionalServicesStr)) {
            return null;
        }
        $additionalServicesIds = collect(explode('-', $additionalServicesStr));

        $additionalServicesIds->transform(function ($item) {
            return (int)$item;
        });

        return $additionalServicesIds;
    }


}