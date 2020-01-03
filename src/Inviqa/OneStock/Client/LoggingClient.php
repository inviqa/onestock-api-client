<?php

namespace Inviqa\OneStock\Client;

use Inviqa\OneStock\Entity\LineItem;
use Inviqa\OneStock\LineUpdater\LineItemUpdateRequest;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequest;
use Psr\Log\LoggerInterface;

class LoggingClient implements ApiClient
{
    /**
     * @var ApiClient
     */
    private $innerClient;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(ApiClient $innerClient, LoggerInterface $logger)
    {
        $this->innerClient = $innerClient;
        $this->logger = $logger;
    }

    public function createOrder(JsonRequest $request): OneStockResponse
    {
        $response = $this->innerClient->createOrder($request);
        $this->log(__METHOD__, 'order_id', [$request->order->id], $response);

        return $response;
    }

    public function updateLineItems(LineItemUpdateRequest $request): OneStockResponse
    {
        $response = $this->innerClient->updateLineItems($request);
        $this->log(__METHOD__, 'item_id', array_map(function (LineItem $item) {
            return $item->item_id;
        }, $request->items), $response);

        return $response;
    }

    private function log(string $methodName, string $idField, array $idValues, OneStockResponse $response)
    {
        $level = $response->isSuccess() ? 'info' : 'error';
        $this->logger->log($level, 'OneStock API', [
            'method' => $methodName,
            $idField => $idValues,
            'request' => $response->request()->getBody()->__toString(),
            'response' => $response->response()->getBody()->__toString(),
            'http_code' => $response->response()->getStatusCode(),
            'http_reason' => $response->response()->getReasonPhrase(),
        ]);
    }
}
