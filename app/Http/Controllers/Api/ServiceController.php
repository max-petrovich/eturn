<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ServiceRepository;
use App\Transformers\ServiceTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use Response;

class ServiceController extends ApiController
{

    /**
     * @var ServiceRepository
     */
    private $services;

    /**
     * ServiceController constructor.
     * @param ServiceRepository $services
     */
    public function __construct(ServiceRepository $services){
        $this->services = $services;
    }


    /**
     * Get services which have  masters
     * @return \Illuminate\Http\JsonResponse
     */
    public function services()
    {
        $services = $this->services->hasMasters();

        if ($services->isEmpty()) {
            return $this->respondNotFound();
        } else {
            return fractal()->collection($services, new ServiceTransformer());
        }
    }
}
