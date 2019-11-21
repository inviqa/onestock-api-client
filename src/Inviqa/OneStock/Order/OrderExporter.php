<?php

namespace Inviqa\OneStock\Order;

use Inviqa\OneStock\Client\ApiClient;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequestBuilder;
use Inviqa\OneStock\Response\ResponseParser;

class OrderExporter
{
    private $jsonRequestBuilder;
    private $apiClient;
    private $responseParser;

    public function __construct(
        JsonRequestBuilder $jsonRequestBuilder,
        ApiClient $apiClient,
        ResponseParser $responseParser
    )
    {
        $this->jsonRequestBuilder = $jsonRequestBuilder;
        $this->apiClient = $apiClient;
        $this->responseParser = $responseParser;
    }

    public function export(array $orderParams): OneStockResponse
    {
        $request = $this->jsonRequestBuilder->buildRequestFrom($orderParams);
        $apiResponse = $this->apiClient->createOrder($request);

        return $this->responseParser->parse($apiResponse);
    }
}
