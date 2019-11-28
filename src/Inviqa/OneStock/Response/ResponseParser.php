<?php

namespace Inviqa\OneStock\Response;

use Inviqa\OneStock\OneStockResponse;

class ResponseParser
{
    public function parse(string $response)
    {
        return new OneStockResponse($response);
    }
}
