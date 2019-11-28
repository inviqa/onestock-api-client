<?php

namespace Inviqa\OneStock\Client;

use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequest;

interface ApiClient
{
    public function createOrder(JsonRequest $request): OneStockResponse;
}
