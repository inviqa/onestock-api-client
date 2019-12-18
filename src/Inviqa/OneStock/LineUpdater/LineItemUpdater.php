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

    public function __construct(ApiClient $apiClinet)
    {
        $this->apiClinet = $apiClinet;
    }

    public function update(array $lineItemUpdateParameters): OneStockResponse
    {
        $request = Invoke::new(LineItemUpdateRequest::class, $lineItemUpdateParameters);
        return $this->apiClinet->updateLineItems($request);
    }
}
