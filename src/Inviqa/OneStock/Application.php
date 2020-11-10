<?php

namespace Inviqa\OneStock;

use Exception;
use Inviqa\OneStock\Factory\ApiOperationFactory;

class Application
{
    private $orderExporter;

    private $requestAgent;

    public function __construct(Config $config)
    {
        $factory = new ApiOperationFactory($config);

        $this->orderExporter = $factory->createOrderExporter();
        $this->requestAgent = $factory->createRequestAgent();
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
            return $this->requestAgent->lineItemUpdate($lineItemUpdateParameters);
        } catch (Exception $e) {
            throw OneStockException::createFromException($e);
        }
    }

    public function createParcel(array $parameters): OneStockResponse
    {
        try {
            return $this->requestAgent->parcelCreate($parameters);
        } catch (Exception $e) {
            throw OneStockException::createFromException($e);
        }
    }

    public function shortPickItems(array $parameters): OneStockResponse
    {
        try {
            return $this->requestAgent->shortPickItems($parameters);
        } catch (Exception $e) {
            throw OneStockException::createFromException($e);
        }
    }
}
