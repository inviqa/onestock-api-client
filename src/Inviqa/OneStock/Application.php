<?php

namespace Inviqa\OneStock;

use Exception;
use Inviqa\OneStock\Factory\ApiOperationFactory;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Application
{
    private $orderExporter;

    private $lineItemsUpdater;

    public function __construct(Config $config, ?LoggerInterface $logger = null)
    {
        $logger = $logger ?: new NullLogger();
        $factory = new ApiOperationFactory($config, $logger);

        $this->orderExporter = $factory->createOrderExporter();
        $this->lineItemsUpdater = $factory->createLineItemUpdater();
    }

    public function exportOrder(array $orderParams): OneStockResponse
    {
        try {
            return $this->orderExporter->export($orderParams);
        } catch (Exception $e) {
            throw OneStockException::createFromException($e);
        }
    }

    public function updateLineItems(array $lineItemUpdateParameters): OneStockResponse
    {
        try {
            return $this->lineItemsUpdater->update($lineItemUpdateParameters);
        } catch (Exception $e) {
            throw OneStockException::createFromException($e);
        }
    }
}
