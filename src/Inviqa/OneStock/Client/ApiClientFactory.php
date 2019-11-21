<?php

namespace Inviqa\OneStock\Client;

class ApiClientFactory
{
    public static function createApiClient(bool $testMode): ApiClient
    {
        if ($testMode) {
            return new FakeClient();
        }

        return new HttpClient();
    }
}
