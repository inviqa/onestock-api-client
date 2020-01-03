<?php

namespace Inviqa\OneStock\Client;

use Inviqa\OneStock\LineUpdater\LineItemUpdateRequest;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequest;

class LoggingClient implements ApiClient
{
    /**
     * @var ApiClient
     */
    private $innerClient;

    public function __construct(ApiClient $innerClient)
    {
        $this->innerClient = $innerClient;
    }

    public function createOrder(JsonRequest $request): OneStockResponse
    {
        return $this->innerClient->createOrder($request);
    }

    public function updateLineItems(LineItemUpdateRequest $request): OneStockResponse
    {
        return $this->innerClient->updateLineItems($request);
    }
}
