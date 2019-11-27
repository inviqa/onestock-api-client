<?php

namespace Services;

use Inviqa\OneStock\Config;

class TestConfig implements Config
{
    public function endpoint(): string
    {
        return 'https://api-qualif.onestock-retail.com/';
    }

    public function username(): string
    {
        return '';
    }

    public function password(): string
    {
        return '';
    }

    public function siteId(): string
    {
        return 's100';
    }

    public function isTestMode(): bool
    {
        return true;
    }

    public function extraParameters(): array
    {
        return [];
    }
}
