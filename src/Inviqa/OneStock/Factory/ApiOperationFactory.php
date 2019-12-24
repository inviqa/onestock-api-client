<?php

namespace Inviqa\OneStock\Factory;

use Inviqa\OneStock\Client\HttpClient;
use Inviqa\OneStock\Config;
use Inviqa\OneStock\LineUpdater\LineItemUpdater;
use Inviqa\OneStock\Order\OrderExporter;
use Inviqa\OneStock\Order\OrderSanitizer;
use Inviqa\OneStock\Order\Request\JsonRequestBuilder;

class ApiOperationFactory
{
    public static function createLineItemUpdater(Config $config, HttpClient $client): LineItemUpdater
    {
        return new LineItemUpdater(
            $client,
            $config->siteId()
        );
    }

    public static function createOrderExporter(Config $config, HttpClient $client)
    {
        return new OrderExporter(
            new JsonRequestBuilder($config, new OrderSanitizer()),
            $client
        );
    }
}
