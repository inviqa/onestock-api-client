<?php

namespace Services;

use VCR\VCR;

class HttpMock
{
    public function enable(): void
    {
        VCR::configure()
           ->setCassettePath('features/bootstrap/fixtures/php-vcr-casettes')
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