<?php

namespace spec\Inviqa\OneStock\Order;

use Inviqa\OneStock\Client\ApiClient;
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
        $apiClient->createOrder($jsonRequest)->shouldBeCalledOnce()->willReturn($response);

        $this->export($orderParams)->shouldReturn($response);
    }

    function it_throws_an_exception_when_the_response_is_not_successful(
        JsonRequestBuilder $jsonRequestBuilder,
        ApiClient $apiClient,
        JsonRequest $jsonRequest
    )
    {
        $orderParams = ['id' => '123'];
        $response = new OneStockResponse(json_encode(['error' => 'message']));
        $jsonRequestBuilder->buildRequestFrom($orderParams)->willReturn($jsonRequest);
        $apiClient->createOrder($jsonRequest)->willReturn($response);

        $this->shouldThrow(ApiException::class)->duringExport($orderParams);
    }
}
