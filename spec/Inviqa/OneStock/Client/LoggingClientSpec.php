<?php

namespace spec\Inviqa\OneStock\Client;

use Inviqa\OneStock\Client\ApiClient;
use Inviqa\OneStock\Entity\LineItem;
use Inviqa\OneStock\Entity\Order;
use Inviqa\OneStock\LineUpdater\LineItemUpdateRequest;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequest;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;
use PhpSpec\ObjectBehavior;

class LoggingClientSpec extends ObjectBehavior
{
    const EXAMPLE_ORDER_ID = 66;
    const EXAMPLE_REQUEST_BODY = 'i am a request';
    const EXAMPLE_RESPONSE_BODY = 'i am a response';


    function let(
        ApiClient $apiClient,
        LoggerInterface $logger
    )
    {
        $this->beConstructedWith($apiClient, $logger);
    }

    function it_logs_order_create_transactions(
        ApiClient $apiClient,
        JsonRequest $request,
        Order $order,
        OneStockResponse $response,
        RequestInterface $httpRequest,
        ResponseInterface $httpResponse,
        StreamInterface $requestBody,
        StreamInterface $responseBody,
        LoggerInterface $logger
    )
    {
        $request->order = $order;
        $order->id = self::EXAMPLE_ORDER_ID;

        $response->request()->willReturn($httpRequest);
        $response->response()->willReturn($httpResponse);
        $response->isSuccess()->willReturn(true);

        $httpResponse->getBody()->willReturn($responseBody);
        $httpRequest->getBody()->willReturn($requestBody);
        $requestBody->__toString()->willReturn(self::EXAMPLE_REQUEST_BODY);
        $responseBody->__toString()->willReturn(self::EXAMPLE_RESPONSE_BODY);
        $httpResponse->getStatusCode()->willReturn(201);
        $httpResponse->getReasonPhrase()->willReturn('OK');

        $apiClient->createOrder($request)->willReturn($response);

        $this->createOrder($request);

        $logger->log('info', 'OneStock API transaction', [
            'method' => 'createOrder',
            'order_id' => [self::EXAMPLE_ORDER_ID],
            'request' => self::EXAMPLE_REQUEST_BODY,
            'response' => self::EXAMPLE_RESPONSE_BODY,
            'http_code' => 201,
            'http_reason' => 'OK',
        ])->shouldHaveBeenCalled();
    }

    function it_logs_errors(
        ApiClient $apiClient,
        JsonRequest $request,
        Order $order,
        OneStockResponse $response,
        RequestInterface $httpRequest,
        ResponseInterface $httpResponse,
        StreamInterface $requestBody,
        StreamInterface $responseBody,
        LoggerInterface $logger
    )
    {
        $request->order = $order;
        $order->id = self::EXAMPLE_ORDER_ID;

        $response->request()->willReturn($httpRequest);
        $response->response()->willReturn($httpResponse);
        $response->isSuccess()->willReturn(false);

        $httpResponse->getBody()->willReturn($responseBody);
        $httpRequest->getBody()->willReturn($requestBody);
        $requestBody->__toString()->willReturn(self::EXAMPLE_REQUEST_BODY);
        $responseBody->__toString()->willReturn(self::EXAMPLE_RESPONSE_BODY);
        $httpResponse->getStatusCode()->willReturn(401);
        $httpResponse->getReasonPhrase()->willReturn('Not OK');

        $apiClient->createOrder($request)->willReturn($response);

        $this->createOrder($request);

        $logger->log('error', 'OneStock API transaction', [
            'method' => 'createOrder',
            'order_id' => [self::EXAMPLE_ORDER_ID],
            'request' => self::EXAMPLE_REQUEST_BODY,
            'response' => self::EXAMPLE_RESPONSE_BODY,
            'http_code' => 401,
            'http_reason' => 'Not OK',
        ])->shouldHaveBeenCalled();
    }

    function it_logs_line_item_updates(
        ApiClient $apiClient,
        LineItemUpdateRequest $request,
        LineItem $item,
        OneStockResponse $response,
        RequestInterface $httpRequest,
        ResponseInterface $httpResponse,
        StreamInterface $requestBody,
        StreamInterface $responseBody,
        LoggerInterface $logger
    )
    {
        $request->items = [ $item ] ;
        $item->item_id = self::EXAMPLE_ORDER_ID;

        $response->request()->willReturn($httpRequest);
        $response->response()->willReturn($httpResponse);
        $response->isSuccess()->willReturn(true);

        $httpResponse->getBody()->willReturn($responseBody);
        $httpRequest->getBody()->willReturn($requestBody);
        $requestBody->__toString()->willReturn(self::EXAMPLE_REQUEST_BODY);
        $responseBody->__toString()->willReturn(self::EXAMPLE_RESPONSE_BODY);
        $httpResponse->getStatusCode()->willReturn(201);
        $httpResponse->getReasonPhrase()->willReturn('OK');

        $apiClient->updateLineItems($request)->willReturn($response);

        $this->updateLineItems($request);

        $logger->log('info', 'OneStock API transaction', [
            'method' => 'updateLineItems',
            'item_id' => [self::EXAMPLE_ORDER_ID],
            'request' => self::EXAMPLE_REQUEST_BODY,
            'response' => self::EXAMPLE_RESPONSE_BODY,
            'http_code' => 201,
            'http_reason' => 'OK',
        ])->shouldHaveBeenCalled();
    }
}
