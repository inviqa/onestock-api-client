<?php

namespace Inviqa\OneStock\Order\Request;

use Inviqa\OneStock\Config;
use Inviqa\OneStock\Order\OrderConverter;

class JsonRequestBuilder
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var OrderConverter
     */
    private $converter;

    public function __construct(Config $config, OrderConverter $converter)
    {
        $this->config = $config;
        $this->converter = $converter;
    }

    public function buildRequestFrom($orderParams)
    {
        $order = $this->converter->convert($orderParams);

        return new JsonRequest($this->config->siteId(), $order);
    }
}
