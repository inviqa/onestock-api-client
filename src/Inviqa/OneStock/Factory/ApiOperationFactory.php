<?php

namespace Inviqa\OneStock\Factory;

use GuzzleHttp\ClientInterface;
use Inviqa\OneStock\Agent\RequestAgent;
use Inviqa\OneStock\Client\ApiClientFactory;
use Inviqa\OneStock\Config;
use Inviqa\OneStock\Order\OrderExporter;
use Inviqa\OneStock\Order\OrderSanitizer;
use Inviqa\OneStock\Order\Request\JsonRequestBuilder;

class ApiOperationFactory
{
    private $config;

    private $client;

    public function __construct(Config $config, ClientInterface $httpClient)
    {
        $this->config = $config;
        $this->client = ApiClientFactory::createApiClient($config, $httpClient);
    }

    public function createRequestAgent(): RequestAgent
    {
        return new RequestAgent(
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
