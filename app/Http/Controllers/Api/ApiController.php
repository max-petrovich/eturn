<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Response;

class ApiController extends BaseController
{
    protected  $statusCode = 200;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondNotFound($message = 'Not found')
    {
        $this->setStatusCode(404);
        return $this->respond([
            'message' => $message,
        ]);
    }


    public function respondBadRequest($message = 'Bad Request')
    {
        $this->setStatusCode(400);

        return $this->respond([
            'message' => $message,
        ]);
    }

    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }
}