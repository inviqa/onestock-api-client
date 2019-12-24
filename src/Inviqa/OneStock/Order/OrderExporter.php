<?php

namespace Inviqa\OneStock\Order;

use Inviqa\OneStock\Client\HttpClient;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Exception\ApiException;
use Inviqa\OneStock\Order\Request\JsonRequestBuilder;

class OrderExporter
{
    private $jsonRequestBuilder;
    private $httpClient;

    public function __construct(
        JsonRequestBuilder $jsonRequestBuilder,
        HttpClient $httpClient
    ) {
        $this->jsonRequestBuilder = $jsonRequestBuilder;
        $this->httpClient = $httpClient;
    }

    public function export(array $orderParams): OneStockResponse
    {
        $request = $this->jsonRequestBuilder->buildRequestFrom($orderParams);
        $response = $this->httpClient->createOrder($request);

        if (!$response->isSuccess()) {
            throw ApiException::createFromJsonResponse($response);
        }

        return $response;
    }
}
