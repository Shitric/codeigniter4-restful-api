<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function successResponse($data, $message = null, $code = 200)
    {
        return $this->response->setStatusCode($code)->setJSON([
            'status' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function errorResponse($message, $code)
    {
        return $this->response->setStatusCode($code)->setJSON([
            'status' => false,
            'message' => $message,
            'data' => null
        ]);
    }
}
