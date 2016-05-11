<?php namespace App\Services;

use App\Entities\Procedure;
use App\Models\ClosedDate;
use App\Models\Order;
use App\Models\User;
use App\Models\UserSchedule;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Request;

class BookingService
{

    /**
     * Get free intervals to master a certain date
     * @param $masters Collection
     * @param $procedure \App\Entities\Procedure
     * @param $date string
     * @return array|null
     */
    public function getAvailableIntervals(Collection $masters, Procedure $procedure, Carbon $date)
    {
        $result = collect();

        $dateSqlFormat = $date->toDateString();


        $procedureService = new ProcedureService($procedure);

        /**
         * Check date in closed days
         */
        if (ClosedDate::find($dateSqlFormat)) {
            return null;
        }

        /**
         * Get intervals for every master
         */
        foreach ($masters as $master) {
            $masterAvailableIntervals = collect(); // result var
            // ================================
            $availableIntervals = collect();

            $masterMinimumServiceDuration = $master->getData('minimum_service_duration');

            /**
             * Correct schedule for every master at that $date
             */

            // Get master schedule for Weekday
            $masterSchedule = $master->schedule()->weekday($date->dayOfWeek)->first();
            // Get schedule exception for that $date
            $masterScheduleException = $master->scheduleException()->date($dateSqlFormat)->first();
            if (!is_null($masterScheduleException)) {
                // Correct schedule
                $masterSchedule->time_start = $masterScheduleException->time_start;
                $masterSchedule->time_end = $masterScheduleException->time_end;
            }

            /**
             * Check if master have day off at that $date
             */
            if (!is_null($masterSchedule->time_start)) {
                /**
                 * Generate all possible time intervals for this master
                 */
                $possibleIntervals = $this->createTimeIntervals($masterSchedule->time_start, $masterSchedule->time_end, $masterMinimumServiceDuration);
                /**
                 * CHECK if any intervals are employed (have order)
                 * Select ORDER at that date
                 */
                $masterOrders = $master->masterOrders()->date($dateSqlFormat)->orderBy('visit_start')->get();

                if ($masterOrders->count()) {

                    $employedIntervals = collect();

                    foreach ($masterOrders as $order) {
                        $orderProcedureDuration = $order->getProcedureDuration();
                        /**
                         * Correct employed intervals according to master minimum service duration
                         */
                        if ($orderProcedureDuration % $masterMinimumServiceDuration !== 0) {
                            $orderProcedureDurationCorrected = $orderProcedureDuration + ($masterMinimumServiceDuration - ($orderProcedureDuration % $masterMinimumServiceDuration));
                        } else {
                            $orderProcedureDurationCorrected = $orderProcedureDuration;
                        }
                        $orderTimeInterval = [
                            'start' => $order->visit_start->toTimeString(),
                            'end' => $order->visit_start->addMinutes($orderProcedureDurationCorrected)->toTimeString()
                        ];
                        // Generate time interval for this order (split order time interval according to min service duration)
                        $employedIntervals = $employedIntervals->merge($this->createTimeIntervals($orderTimeInterval['start'], $orderTimeInterval['end'], $masterMinimumServiceDuration)->toArray());
                    }


                    /**
                     * Remove from possible intervals employed intervals
                     */
                    $availableIntervalsKeys = $possibleIntervals->keys()->diff($employedIntervals->keys());

                    if ($availableIntervalsKeys->count()) {
                        foreach ($availableIntervalsKeys as $availableIntervalsKey) {
                            $availableIntervals->push($possibleIntervals->get($availableIntervalsKey));
                        }
                    }
                } else {
                    $availableIntervals = $possibleIntervals;
                }


                /**
                 * Combine standing next interval ( example: [11:00, 12:00], [12:00,13:00] => [11:00, 13:00] )
                 */

                $availableForOrderIntervals = collect($availableIntervals->toArray());

                // Для каждого интервала нужно найти его окончание, (просмотрев все интервалы после него)

                $availableForOrderIntervals->transform(function ($interval, $key) use($availableForOrderIntervals){
                    $interval[1] = $this->searchEndOfInterval($interval[1], $availableForOrderIntervals);
                    return $interval;
                });

                /**
                 * Check whether the procedure will enter at least one interval
                 */
                $procedureMasterInfo = $procedureService->getInfoForMaster($master);

                $procedureDuration = $procedureMasterInfo['duration'];

                foreach ($availableForOrderIntervals as $interval) {
                    // Check duration
                    $intervalDuration = Carbon::parse($interval[1])->diffInMinutes(Carbon::parse($interval[0]));
                    if ($intervalDuration >= $procedureDuration) {
                        /**
                         * INTERVAL ACCEPTED
                         */
                        /**
                         * Correct interval end according to procedure duration
                         */
                        $interval[1] = Carbon::parse($interval[0])->addMinutes($procedureDuration)->toTimeString();
                        $masterAvailableIntervals->push($interval);
                    }
                }

                /**
                 * Add master and intervals to RESULT
                 */
                if ($masterAvailableIntervals->count()) {

                    $result->push([
                        'master' => $master,
                        'price' => $procedureMasterInfo['price'],
                        'intervals' => $masterAvailableIntervals
                    ]);
                }

            }
        }

        return $result;
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

    /**
     * Create time interval from source data
     * @param $timeStart
     * @param $timeEnd
     * @param $interval
     * @return mixed
     */
    
    private function createTimeIntervals($timeStart, $timeEnd, $interval){
        $timeStart = Carbon::parse($timeStart);

        $intervals = collect();

        while ($timeStart < Carbon::parse($timeEnd)) {
            $intervalStart = $timeStart->toTimeString();
            $intervalEnd = $timeStart->addMinutes($interval)->toTimeString();
            $intervals->put($intervalStart.$intervalEnd, [
                $intervalStart,
                $intervalEnd
            ]);
        }

        return $intervals;
    }

    /**
     * Search for each time interval ending
     * @param $intervalEnd
     * @param $allIntervals
     * @return mixed
     */

    private function searchEndOfInterval($intervalEnd, $allIntervals)
    {
        foreach ($allIntervals as $interval) {
            if ($interval[0] == $intervalEnd) { // next interval start == current interval end
                $intervalEnd = $interval[1];
            }
        }

        return $intervalEnd;
    }


}