<?php

namespace Inviqa\OneStock\Order;

use Inviqa\OneStock\Config;

class OrderExporterFactory
{
    public static function createFromConfig(Config $config)
    {
        return new OrderExporter($config);
    }
}
