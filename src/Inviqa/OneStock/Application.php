<?php

namespace Inviqa\OneStock;

use Exception;
use Inviqa\OneStock\Order\OrderExporterFactory;

class Application
{
    private $config;

    private $orderExporter;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->orderExporter = OrderExporterFactory::createFromConfig($config);
    }

    public function exportOrder(array $orderParams): OneStockResponse
    {
        try {
            return $this->orderExporter->export($orderParams);
        } catch (Exception $e) {
            throw OneStockException::createFromException($e);
        }
    }
}
