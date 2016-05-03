<?php namespace App\Transformers;

use App\Models\Service;
use League\Fractal;

class ServiceTransformer extends Fractal\TransformerAbstract
{

    public function transform(Service $service)
    {
        return [
            'id' => $service->id,
            'title' => $service->title
        ];
    }
}