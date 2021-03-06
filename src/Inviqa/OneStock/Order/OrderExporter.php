<?php

namespace Inviqa\OneStock\Order;

use Inviqa\OneStock\Client\ApiClient;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequestBuilder;

class OrderExporter
{
    private $jsonRequestBuilder;
    private $apiClient;

    public function __construct(
        JsonRequestBuilder $jsonRequestBuilder,
        ApiClient $apiClient
    ) {
        $this->jsonRequestBuilder = $jsonRequestBuilder;
        $this->apiClient = $apiClient;
    }

    public function export(array $orderParams): OneStockResponse
    {
        $request = $this->jsonRequestBuilder->buildRequestFrom($orderParams);

        return $this->apiClient->createOrder($request);
    }
}
