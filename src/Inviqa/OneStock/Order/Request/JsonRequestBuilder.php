<?php

namespace Inviqa\OneStock\Order\Request;

use Inviqa\OneStock\Config;
use Inviqa\OneStock\Order\OrderConverter;
use Inviqa\OneStock\Order\OrderSanitizer;

class JsonRequestBuilder
{
    private $config;
    private $sanitizer;
    private $converter;

    public function __construct(Config $config, OrderSanitizer $sanitizer, OrderConverter $converter)
    {
        $this->config = $config;
        $this->sanitizer = $sanitizer;
        $this->converter = $converter;
    }

    public function buildRequestFrom($orderParams)
    {
        $sanitizedParams = $this->sanitizer->sanitize($orderParams);
        $order = $this->converter->convert($sanitizedParams);

        return new JsonRequest($this->config->siteId(), $order);
    }
}
