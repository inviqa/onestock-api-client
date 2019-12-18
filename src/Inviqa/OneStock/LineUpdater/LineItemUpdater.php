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
    private $apiClinet;

    /**
     * @var string
     */
    private $siteId;

    public function __construct(ApiClient $apiClinet, string $siteId)
    {
        $this->apiClinet = $apiClinet;
        $this->siteId = $siteId;
    }

    public function update(array $lineItemUpdateParameters): OneStockResponse
    {
        $request = Invoke::new(LineItemUpdateRequest::class, array_merge([
            'site_id' => $this->siteId,
        ], $lineItemUpdateParameters));

        return $this->apiClinet->updateLineItems($request);
    }
}
