<?php

namespace spec\Inviqa\OneStock\Order;

use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\OrderExporter;
use Inviqa\OneStock\Order\Request\JsonRequest;
use Inviqa\OneStock\Order\Request\JsonRequestBuilder;
use Inviqa\OneStock\Client\ApiClient;
use Inviqa\OneStock\Response\ResponseParser;
use PhpSpec\ObjectBehavior;

/**
 * @mixin OrderExporter
 */
class OrderExporterSpec extends ObjectBehavior
{
    function let(
        JsonRequestBuilder $jsonRequestBuilder,
        ApiClient $apiClient
    )
    {
        $this->beConstructedWith($jsonRequestBuilder, $apiClient);
    }

    function it_delegates_order_exporting(
        JsonRequestBuilder $jsonRequestBuilder,
        ApiClient $apiClient,
        JsonRequest $jsonRequest
    )
    {
        $orderParams = ['id' => '123'];
        $response = new OneStockResponse(json_encode(['id' => '123']));

        $jsonRequestBuilder->buildRequestFrom($orderParams)->willReturn($jsonRequest);
        $apiClient->createOrder($jsonRequest)->willReturn($response);

        $this->export($orderParams)->shouldReturn($response);
    }

}
