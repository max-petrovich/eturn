<?php namespace App\Entities;

use App\Models\AdditionalService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Collection;

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

}