<?php

namespace Inviqa\OneStock\Client;

use GuzzleHttp\Client;
use Inviqa\OneStock\Config;

class ApiClientFactory
{
    public static function createApiClient(Config $config): ApiClient
    {
        if ($config->isTestMode()) {
            return new FakeClient();
        }

        return new HttpClient(
            new Client(['base_uri' => $config->endpoint()]),
            [
                'username' => $config->username(),
                'password' => $config->password(),
            ]
        );
    }
}
