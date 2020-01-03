<?php

namespace Inviqa\OneStock\Client;

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
        $this->logger->info('One Stock Request', [
        ]);

        return $this->innerClient->createOrder($request);
    }

    public function updateLineItems(LineItemUpdateRequest $request): OneStockResponse
    {
        return $this->innerClient->updateLineItems($request);
    }
}
