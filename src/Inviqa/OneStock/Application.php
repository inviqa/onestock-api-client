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

    /**
     * @param $orderParams
     *
     * @throws OneStockException
     *
     * @return OneStockResponse
     */
    public function exportOrder($orderParams)
    {
        try {
            return $this->orderExporter->export($orderParams);
        } catch (Exception $e) {
            throw OneStockException::createFromException($e);
        }
    }
}
