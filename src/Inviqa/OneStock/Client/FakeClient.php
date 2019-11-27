<?php

namespace Inviqa\OneStock\Client;

use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequest;

class FakeClient implements ApiClient
{
    public function createOrder(JsonRequest $request): OneStockResponse
    {
        return new OneStockResponse(json_encode(['id' => $request->order->id]));
    }
}
