<?php

namespace spec\Inviqa\OneStock\Order;

use Inviqa\OneStock\Client\HttpClient;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Exception\ApiException;
use Inviqa\OneStock\Order\OrderExporter;
use Inviqa\OneStock\Order\Request\JsonRequest;
use Inviqa\OneStock\Order\Request\JsonRequestBuilder;
use PhpSpec\ObjectBehavior;

/**
 * @mixin OrderExporter
 */
class OrderExporterSpec extends ObjectBehavior
{
    function let(
        JsonRequestBuilder $jsonRequestBuilder,
        HttpClient $httpClient
    )
    {
        $this->beConstructedWith($jsonRequestBuilder, $httpClient);
    }

    function it_delegates_order_exporting(
        JsonRequestBuilder $jsonRequestBuilder,
        HttpClient $httpClient,
        JsonRequest $jsonRequest
    )
    {
        $orderParams = ['id' => '123'];
        $response = new OneStockResponse(json_encode(['id' => '123']));

        $jsonRequestBuilder->buildRequestFrom($orderParams)->willReturn($jsonRequest);
        $httpClient->createOrder($jsonRequest)->shouldBeCalledOnce()->willReturn($response);

        $this->export($orderParams)->shouldReturn($response);
    }

    function it_throws_an_exception_when_the_response_is_not_successful(
        JsonRequestBuilder $jsonRequestBuilder,
        HttpClient $httpClient,
        JsonRequest $jsonRequest
    )
    {
        $orderParams = ['id' => '123'];
        $response = new OneStockResponse(json_encode(['error' => 'message']));
        $jsonRequestBuilder->buildRequestFrom($orderParams)->willReturn($jsonRequest);
        $httpClient->createOrder($jsonRequest)->willReturn($response);

        $this->shouldThrow(ApiException::class)->duringExport($orderParams);
    }
}
