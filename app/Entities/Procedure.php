<?php namespace App\Entities;

use App\Models\AdditionalService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class Procedure
{

    /**
     * TODO If the services will have a default rates
     * Duration service with additional services
     * @var int
     */
    private $duration = 0;
    /**
     * @var Service
     */
    private $service;
    /**
     * @var Collection
     */
    private $additionalServices;

    public function __construct(Service $service, Collection $additionalServices = null)
    {
        $this->service = $service;
        $this->additionalServices = $additionalServices;
    }

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return Collection
     */
    public function getAdditionalServices()
    {
        return $this->additionalServices;
    }

    /**
     * @param Collection $additionalServices
     */
    public function setAdditionalServices(Collection $additionalServices)
    {
        $this->additionalServices = $additionalServices;
    }

    /**
     * @return int
     */
    public function getDurationForMaster(User $master)
    {
        $duration = 0;

        $userService = $master->services()->whereId($this->service->id)->first();
        $duration += $userService->pivot->duration;

        // If additional services isset - add duration
        if (!is_null($this->additionalServices) && $this->additionalServices->count()) {
            $additionalServices = $master->additionalServices()->whereIn('additional_service_id', $this->additionalServices->pluck('id')->toArray())->get();

            foreach ($additionalServices as $aService) {
                $duration += $aService->pivot->duration;
            }
        }

        return $duration;
    }



}