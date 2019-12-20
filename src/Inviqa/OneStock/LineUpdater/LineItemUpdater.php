<?php

namespace Inviqa\OneStock\LineUpdater;

use DTL\Invoke\Invoke;
use Inviqa\OneStock\Client\ApiClient;
use Inviqa\OneStock\OneStockResponse;

class LineItemUpdater
{
    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var string
     */
    private $siteId;

    public function __construct(ApiClient $apiClinet, string $siteId)
    {
        $this->apiClient = $apiClinet;
        $this->siteId = $siteId;
    }

    public function update(array $lineItemUpdateParameters): OneStockResponse
    {
        $request = Invoke::new(LineItemUpdateRequest::class, [
            'site_id' => $this->siteId,
            'items' => $lineItemUpdateParameters,
        ]);

        return $this->apiClient->updateLineItems($request);
    }
}
