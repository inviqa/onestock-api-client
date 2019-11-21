<?php

namespace Services;

use Inviqa\OneStock\Config;

class TestConfig implements Config
{
    public function endpoint(): string
    {
        return '';
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
        return '';
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
