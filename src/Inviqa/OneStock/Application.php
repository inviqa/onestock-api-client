<?php

namespace Inviqa\OneStock;

use Exception;
use Inviqa\OneStock\Client\ApiClientFactory;
use Inviqa\OneStock\Order\OrderExporterFactory;

class Application
{
    private $config;

    private $orderExporter;

    public function __construct(Config $config)
    {
        $client = ApiClientFactory::createApiClient($config);
        $this->orderExporter = OrderExporterFactory::createFromConfig($config, $client);
    }

    public function exportOrder(array $orderParams): OneStockResponse
    {
        try {
            return $this->orderExporter->export($orderParams);
        } catch (Exception $e) {
            throw OneStockException::createFromException($e);
        }
    }

    public function updateLineItems(array $lineItemUpdateParameters)
    {
        try {
            return $this->lineItemUpdater->update($lineItemUpdateParameters);
        } catch (Exception $e) {
            throw OneStockException::createFromException($e);
        }
    }
}
