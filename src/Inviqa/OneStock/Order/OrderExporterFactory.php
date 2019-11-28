<?php

namespace Inviqa\OneStock\Order;

use Inviqa\OneStock\Client\ApiClientFactory;
use Inviqa\OneStock\Config;
use Inviqa\OneStock\Order\Request\JsonRequestBuilder;
use Inviqa\OneStock\Response\ResponseParser;

class OrderExporterFactory
{
    public static function createFromConfig(Config $config)
    {
        return new OrderExporter(
            new JsonRequestBuilder($config, new OrderSanitizer(), new OrderConverter()),
            ApiClientFactory::createApiClient($config)
        );
    }
}
