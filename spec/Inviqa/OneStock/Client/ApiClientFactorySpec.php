<?php

namespace spec\Inviqa\OneStock\Client;

use GuzzleHttp\ClientInterface;
use Inviqa\OneStock\Client\ApiClient;
use Inviqa\OneStock\Client\ApiClientFactory;
use Inviqa\OneStock\Client\HttpClient;
use Inviqa\OneStock\Config;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;

/**
 * @mixin ApiClientFactory
 */
class ApiClientFactorySpec extends ObjectBehavior
{
    function it_creates_a_http_client_when_not_in_test_mode(Config $config, ClientInterface $httpClient)
    {
        $config->endpoint()->willReturn('foo');
        $config->username()->willReturn('bar');
        $config->password()->willReturn('pass');
        $config->extraParameters()->willReturn([]);

        $this->createApiClient($config, $httpClient)->shouldHaveType(ApiClient::class);
    }
}
