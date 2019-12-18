<?php

namespace spec\Inviqa\OneStock\Order;

use GuzzleHttp\ClientInterface;
use Inviqa\OneStock\Client\ApiClient;
use Inviqa\OneStock\Config;
use Inviqa\OneStock\Order\OrderExporterFactory;
use Inviqa\OneStock\Order\OrderExporter;
use PhpSpec\ObjectBehavior;

class OrderExporterFactorySpec extends ObjectBehavior
{
    function it_creates_an_order_exporter(Config $config, ApiClient $client)
    {
        $config->isTestMode()->willReturn(true);

        $this::createFromConfig($config, $client)->shouldBeAnInstanceOf(OrderExporter::class);
    }
}
