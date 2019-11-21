<?php

namespace spec\Inviqa\OneStock\Order;

use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\OrderExporter;
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
        ApiClient $apiClient,
        ResponseParser $responseParser
    )
    {
        $this->beConstructedWith($jsonRequestBuilder, $apiClient, $responseParser);
    }

    function it_delegates_order_exporting(
        JsonRequestBuilder $jsonRequestBuilder,
        ApiClient $apiClient,
        ResponseParser $responseParser,
        OneStockResponse $response
    )
    {
        $orderParams = ['id' => '123'];
        $jsonRequest = json_encode($orderParams);
        $jsonResponse = json_encode(['message' => 'OK']);

        $jsonRequestBuilder->buildRequestFrom($orderParams)->willReturn($jsonRequest);
        $apiClient->createOrder($jsonRequest)->willReturn($jsonResponse);
        $responseParser->parse($jsonResponse)->willReturn($response);

        $this->export($orderParams)->shouldReturn($response);
    }

}
