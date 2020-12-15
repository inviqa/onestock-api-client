<?php

namespace Inviqa\OneStock\Client;

use GuzzleHttp\ClientInterface;
use Inviqa\OneStock\Config;
use Inviqa\OneStock\Factory\SerializerFactory;

class ApiClientFactory
{
    public static function createApiClient(Config $config, ClientInterface $httpClient): ApiClient
    {
        $extraParameters = $config->extraParameters();
        $usernameHeader = $extraParameters['authentication_username_header'] ?? null;
        $passwordHeader = $extraParameters['authentication_password_header'] ?? null;
        $customAuthentication = !empty($usernameHeader) && !empty($passwordHeader);
        $authentication = $customAuthentication
            ? new HttpAuthentication(
                $config->username(),
                $config->password(),
                $usernameHeader,
                $passwordHeader
            )
            : new HttpAuthentication(
                $config->username(),
                $config->password()
            );

        return new HttpClient(
            $httpClient,
            $authentication,
            (new SerializerFactory())->createSerializer()
        );
    }
}
