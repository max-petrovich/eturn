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
        $fullInfo = $this->getFullInfoForMaster($master);
        return $fullInfo['all'];
    }

    public function getFullInfoForMaster(User $master)
    {
        $info = collect();

        $fullDuration = 0;
        $fullPrice = 0;

        $masterService = $master->services()->find($this->procedure->getService()->id);

        /**
         * Service
         */
        $info->put('service', [
            'id' => $masterService->id,
            'title' => $masterService->title,
            'duration' => $masterService->pivot->duration,
            'price' => $masterService->pivot->price
        ]);

        $fullDuration = $masterService->pivot->duration;
        $fullPrice = $masterService->pivot->price;

        /**
         * Additional services
         */

        if (!is_null($this->procedure->getAdditionalServices()) && $this->procedure->getAdditionalServices()->count()) {
            $masterAdditionalServices = $master->additionalServices()->whereIn('additional_service_id',
                $this->procedure->getAdditionalServices()->pluck('id')->toArray())->get();

            if (!is_null($masterAdditionalServices) && $masterAdditionalServices->count()) {
                $infoAdditionalServices = collect();
                foreach ($masterAdditionalServices as $aService) {
                    $infoAdditionalServices->put($aService->id, [
                        'id' => $aService->id,
                        'title' => $aService->title,
                        'duration' => $aService->pivot->duration,
                        'price' => $aService->pivot->price
                    ]);

                    $fullDuration += $aService->pivot->duration;
                    $fullPrice += $aService->pivot->price;
                }

                $info->put('additionalServices', $infoAdditionalServices->toArray());
            }
        }

        $info->put('all', [
            'duration' => $fullDuration,
            'price' => $fullPrice
        ]);

        return $info;
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