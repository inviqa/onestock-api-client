<?php

namespace Inviqa\OneStock\Factory;

use Inviqa\OneStock\Client\ApiClientFactory;
use Inviqa\OneStock\Config;
use Inviqa\OneStock\LineUpdater\LineItemUpdater;
use Inviqa\OneStock\Order\OrderExporter;
use Inviqa\OneStock\Order\OrderSanitizer;
use Inviqa\OneStock\Order\Request\JsonRequestBuilder;

class ApiOperationFactory
{
    private $config;

    private $client;

    public function __construct(Config $config, $logger)
    {
        $this->config = $config;
        $this->client = ApiClientFactory::createApiClient($config, $logger);
    }

    public function createLineItemUpdater(): LineItemUpdater
    {
        return new LineItemUpdater(
            $this->client,
            $this->config->siteId()
        );
    }

    public function createOrderExporter(): OrderExporter
    {
        return new OrderExporter(
            new JsonRequestBuilder($this->config, new OrderSanitizer()),
            $this->client
        );
    }
}
