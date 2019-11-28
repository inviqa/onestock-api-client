<?php

namespace Inviqa\OneStock;

class OneStockResponse
{
    private $success;

    public function __construct(string $response)
    {
        $this->success = !empty(json_decode($response, true)['id']);
    }

    public function isSuccess()
    {
        return $this->success;
    }
}
