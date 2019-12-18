<?php

namespace Inviqa\OneStock\Order;

use Inviqa\OneStock\Client\ApiClient;
use Inviqa\OneStock\Config;
use Inviqa\OneStock\Order\Request\JsonRequestBuilder;

class OrderExporterFactory
{
    public static function createFromConfig(Config $config, ApiClient $client)
    {
        return new OrderExporter(
            new JsonRequestBuilder($config, new OrderSanitizer()),
            $client
        );
    }
}
