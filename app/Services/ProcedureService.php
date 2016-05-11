<?php namespace App\Services;

use App\Entities\Procedure;
use App\Models\User;

class ProcedureService
{

    /**
     * @var Procedure
     */
    private $procedure;

    public function __construct(Procedure $procedure)
    {
        $this->procedure = $procedure;
    }

    /**
     * @return Procedure
     */
    public function getProcedure()
    {
        return $this->procedure;
    }

    /**
     * @param Procedure $procedure
     */
    public function setProcedure($procedure)
    {
        $this->procedure = $procedure;
    }

    /**
     * Get procedure counter (duration and price) for defined master
     * @param User $master
     * @return int
     */

    public function getInfoForMaster(User $master)
    {
        $duration = 0;
        $price = 0;

        $userService = $master->services()->whereId($this->procedure->getService()->id)->first();
        $duration += $userService->pivot->duration;
        $price += $userService->pivot->price;

        // If additional services isset - add duration
        if (!is_null($this->procedure->getAdditionalServices()) && $this->procedure->getAdditionalServices()->count()) {
            $additionalServices = $master->additionalServices()->whereIn('additional_service_id', $this->procedure->getAdditionalServices()->pluck('id')->toArray())->get();

            foreach ($additionalServices as $aService) {
                $duration += $aService->pivot->duration;
                $price += $aService->pivot->price;
            }
        }

        return [
            'duration' => $duration,
            'price' => $price
        ];
    }

    public function getDurationForMaster(User $master)
    {
        $data = $this->getInfoForMaster($master);
        return $data['duration'];
    }

    public function getPriceForMaster(User $master)
    {
        $data = $this->getInfoForMaster($master);
        return $data['price'];
    }
}