<?php

namespace Inviqa\OneStock\LineUpdater;

use Inviqa\OneStock\Client\HttpClient;
use Inviqa\OneStock\Config;

class LineUpdaterFactory
{
    public static function create(Config $config, HttpClient $client): LineItemUpdater
    {
        return new LineItemUpdater(
            $client,
            $config->siteId()
        );
    }
}
