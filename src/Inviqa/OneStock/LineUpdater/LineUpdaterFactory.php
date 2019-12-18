<?php

namespace Inviqa\OneStock\LineUpdater;

use Inviqa\OneStock\Client\ApiClient;
use Inviqa\OneStock\Config;

class LineUpdaterFactory
{
    public static function create(Config $config, ApiClient $client): LineItemUpdater
    {
        return new LineItemUpdater(
            $client,
            $config->siteId()
        );
    }
}
