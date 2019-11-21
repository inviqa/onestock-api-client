<?php

namespace Inviqa\OneStock\Order;

use Inviqa\OneStock\Config;
use Inviqa\OneStock\Order\OrderExporter;

class OrderExporterFactory
{
    public static function createFromConfig(Config $config)
    {
        return new OrderExporter($config);
    }
}
