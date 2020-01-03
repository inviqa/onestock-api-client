<?php

namespace Inviqa\OneStock\Client;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Inviqa\OneStock\Config;
use Psr\Log\LoggerInterface;

class ApiClientFactory
{
    public static function createApiClient(Config $config, LoggerInterface $logger): ApiClient
    {
        $client = new HttpClient(
            new Client([
                'base_uri' => $config->endpoint(),
                RequestOptions::HTTP_ERRORS => false,
            ]),
            [
                'username' => $config->username(),
                'password' => $config->password(),
            ]
        );

        return new LoggingClient($client, $logger);
    }
}
