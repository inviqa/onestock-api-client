<?php

namespace spec\Inviqa\OneStock\Client;

use Inviqa\OneStock\Client\ApiClientFactory;
use PhpSpec\ObjectBehavior;

/**
 * @mixin ApiClientFactory
 */
class ApiClientFactorySpec extends ObjectBehavior
{
    function it_creates_an_api_client()
    {
        $this->createApiClient(false);
    }

    function it_creates_a_fake_api_client()
    {
        $this->createApiClient(true);
    }
}
