<?php

namespace Inviqa\OneStock\Client;

use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequest;
use Inviqa\OneStock\LineUpdater\LineItemUpdateRequest;

interface ApiClient
{
    public function createOrder(JsonRequest $request): OneStockResponse;

    public function updateLineItems(LineItemUpdateRequest $request): OneStockResponse;
}
