<?php

namespace Inviqa\OneStock\Client;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Inviqa\OneStock\Config;

class ApiClientFactory
{
    public static function createApiClient(Config $config): ApiClient
    {
        return new HttpClient(
            new Client([
                'base_uri' => $config->endpoint(),
                RequestOptions::HTTP_ERRORS => false,
            ]),
            [
                'username' => $config->username(),
                'password' => $config->password(),
            ]
        );
    }
}
