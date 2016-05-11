<?php

namespace App\Http\Controllers\Api;

use App\Models\ClosedDate;
use App\Transformers\ClosedDateTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClosedDateController extends ApiController
{
    public function all()
    {
        $closedDates = ClosedDate::all();

        if ($closedDates->isEmpty()) {
            return $this->respondNotFound();
        } else {
            return fractal()->collection($closedDates, function ($date){
                return $date->closed_date->toDateString();
            });
        }
    }
}
