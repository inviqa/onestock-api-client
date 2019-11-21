<?php

namespace spec\Inviqa\OneStock\Client;

use Inviqa\OneStock\Client\ApiClient;
use Inviqa\OneStock\Client\ApiClientFactory;
use Inviqa\OneStock\Client\FakeClient;
use Inviqa\OneStock\Client\HttpClient;
use PhpSpec\ObjectBehavior;

/**
 * @mixin ApiClientFactory
 */
class ApiClientFactorySpec extends ObjectBehavior
{
    function it_creates_a_client_based_on_test_mode()
    {
        $this->createApiClient(true)->shouldHaveType(FakeClient::class);
        $this->createApiClient(false)->shouldHaveType(HttpClient::class);
    }
}
