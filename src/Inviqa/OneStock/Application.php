<?php

namespace Inviqa\OneStock;

use Exception;
use Inviqa\OneStock\Client\ApiClientFactory;
use Inviqa\OneStock\Factory\ApiOperationFactory;
use Inviqa\OneStock\LineUpdater\LineItemUpdater;

class Application
{
    private $orderExporter;

    /**
     * @var LineItemUpdater
     */
    private $lineItemsUpdater;

    public function __construct(Config $config)
    {
        $client = ApiClientFactory::createApiClient($config);
        $this->orderExporter = ApiOperationFactory::createOrderExporter($config, $client);
        $this->lineItemsUpdater = ApiOperationFactory::createLineItemUpdater($config, $client);
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
