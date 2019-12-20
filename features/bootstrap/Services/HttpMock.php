<?php

namespace Services;

use VCR\Request;
use VCR\VCR;

class HttpMock
{
    const MOCK_ONESTOCK_ENTITY_EXIST = 'onestock_entity_exist';
    const MOCK_ONESTOCK_SUCCESS = 'onestock_success';

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
           ->setWhiteList(['vendor/guzzle'])
           ->enableLibraryHooks(['curl'])
           ->addRequestMatcher(
                'header_matcher',
                function (Request $first, Request $second) {
                    $firstHeaders = $first->getHeaders();
                    $secondHeaders = $second->getHeaders();
                    unset($firstHeaders['User-Agent']);
                    unset($secondHeaders['User-Agent']);

                    return $firstHeaders == $secondHeaders;
                }
           )
           ->enableRequestMatchers(['method', 'url', 'query_string', 'host', 'body', 'post_fields', 'header_matcher']);
        VCR::turnOn();
        VCR::insertCassette(self::MOCK_ONESTOCK_SUCCESS);
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