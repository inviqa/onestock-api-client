<?php

namespace Services;

use Inviqa\OneStock\Config;

class TestConfig implements Config
{
    private $extraParameters = [
        'error' => '',
        'testOrders' => [],
    ];

    public function endpoint(): string
    {
        return 'https://api-qualif.onestock-retail.com/';
    }

    public function username(): string
    {
        return 'foo';
    }

    public function password(): string
    {
        return 'bar';
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
        return $this->extraParameters;
    }

    public function addError(string $error)
    {
        $this->extraParameters['error'] = $error;
    }
}
