<?php

namespace spec\Inviqa\OneStock\Factory;

use Inviqa\OneStock\Client\HttpClient;
use Inviqa\OneStock\Config;
use Inviqa\OneStock\Factory\ApiOperationFactory;
use Inviqa\OneStock\LineUpdater\LineItemUpdater;
use Inviqa\OneStock\Order\OrderExporter;
use PhpSpec\ObjectBehavior;

class ApiOperationFactorySpec extends ObjectBehavior
{
    function let(Config $config)
    {
        $config->siteId()->willReturn('abc123');
    }

    function it_creates_an_order_exporter(Config $config, HttpClient $client)
    {
        $this::createOrderExporter($config, $client)->shouldBeAnInstanceOf(OrderExporter::class);
    }

    function it_creates_a_line_item_updater(Config $config, HttpClient $client)
    {
        $this::createLineItemUpdater($config, $client)->shouldBeAnInstanceOf(LineItemUpdater::class);
    }
}
