<?php

namespace Services;

use VCR\VCR;

class HttpMock
{
    /**
     * @var string
     */
    private $cassettePath;

    public function __construct(string $cassettePath)
    {
        $this->cassettePath = $cassettePath;
    }

    public function enable(): void
    {
        VCR::configure()
           ->setCassettePath($this->cassettePath)
           ->setWhiteList(array('vendor/guzzle'))
           ->enableLibraryHooks(array('curl'));
        VCR::turnOn();
        VCR::insertCassette('onestock_success');
    }

    public function disable(): void
    {
        VCR::turnOff();
    }

    public function useMocks(string $mockName)
    {
        VCR::insertCassette($mockName);
    }
}