<?php

namespace Inviqa\OneStock;

use Exception;
use Inviqa\OneStock\Client\ApiClientFactory;
use Inviqa\OneStock\LineUpdater\LineItemUpdater;
use Inviqa\OneStock\LineUpdater\LineUpdaterFactory;
use Inviqa\OneStock\Order\OrderExporterFactory;
use Services\HttpMock;

class Application
{
    private $orderExporter;

    /**
     * @var LineItemUpdater
     */
    private $lineItemsUpdater;

    public function __construct(Config $config, HttpMock $httpMock)
    {
        if ($config->isTestMode()) {
            $httpMock->enable();
        }
        $client = ApiClientFactory::createApiClient($config);
        $this->orderExporter = OrderExporterFactory::createFromConfig($config, $client);
        $this->lineItemsUpdater = LineUpdaterFactory::create($config, $client);
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
