<?php

namespace Inviqa\OneStock;

use Inviqa\OneStock\Order\OrderExporterFactory;

class Application
{
    /**
     * @var Config
     */
    private $config;

    private $orderExporter;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->orderExporter = OrderExporterFactory::createFromConfig($config);
    }

    public function exportOrder($orderParams)
    {
        return $this->orderExporter->export($orderParams);
    }
}
