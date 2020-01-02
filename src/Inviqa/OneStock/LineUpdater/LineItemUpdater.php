<?php

namespace Inviqa\OneStock\LineUpdater;

use DTL\Invoke\Invoke;
use Inviqa\OneStock\Client\HttpClient;
use Inviqa\OneStock\OneStockResponse;

class LineItemUpdater
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var string
     */
    private $siteId;

    public function __construct(HttpClient $httpClient, string $siteId)
    {
        $this->httpClient = $httpClient;
        $this->siteId = $siteId;
    }

    public function update(array $lineItemUpdateParameters): OneStockResponse
    {
        $request = Invoke::new(LineItemUpdateRequest::class, [
            'site_id' => $this->siteId,
            'items' => $lineItemUpdateParameters,
        ]);

        return $this->httpClient->updateLineItems($request);
    }
}
