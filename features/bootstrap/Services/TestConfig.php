<?php

namespace Services;

use Inviqa\OneStock\Config;

class TestConfig implements Config
{
    /**
     * @var HttpMock
     */
    private $httpMock;

    public function __construct(string $cassettePath)
    {
        $this->httpMock = new HttpMock($cassettePath);
        $this->httpMock->enable();
    }

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
        return 'test-user';
    }

    public function password(): string
    {
        return 'test-password';
    }

    public function siteId(): string
    {
        return 's100';
    }

    public function extraParameters(): array
    {
        return $this->extraParameters;
    }

    public function addError(string $error)
    {
        $this->extraParameters['error'] = $error;
    }

    public function addExtraParameter(string $name, string $value): void
    {
        $this->extraParameters[$name] = $value;
    }

    public function getHttpMock(): HttpMock
    {
        return $this->httpMock;
    }
}
