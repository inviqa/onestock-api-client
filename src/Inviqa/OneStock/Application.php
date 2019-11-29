<?php

namespace Inviqa\OneStock;

use Exception;
use Inviqa\OneStock\Order\Exception\ApiException;
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
            $response = $this->orderExporter->export($orderParams);
            if (!$response->isSuccess()) {
                throw ApiException::createFromJsonResponse($response);
            }

            return $response;
        } catch (Exception $e) {
            throw OneStockException::createFromException($e);
        }
    }
}
