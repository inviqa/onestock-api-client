<?php

namespace Inviqa\OneStock\Agent;

use DTL\Invoke\Invoke;
use Inviqa\OneStock\Client\ApiClient;
use Inviqa\OneStock\LineUpdater\LineItemUpdateRequest;
use Inviqa\OneStock\LineUpdater\ShortPickRequest;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Parcel\ParcelCreateRequest;

final class RequestAgent
{
    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var string
     */
    private $siteId;

    public function __construct(ApiClient $apiClient, string $siteId)
    {
        $this->apiClient = $apiClient;
        $this->siteId = $siteId;
    }

    public function lineItemUpdate(array $lineItemUpdateParameters): OneStockResponse
    {
        $request = Invoke::new(LineItemUpdateRequest::class, [
            'site_id' => $this->siteId,
            'items' => $lineItemUpdateParameters,
        ]);

        return $this->apiClient->request('PATCH', 'multi/line_items', $request);
    }

    public function parcelCreate(array $parameters): OneStockResponse
    {
        $request = Invoke::new(ParcelCreateRequest::class, [
            'site_id' => $this->siteId,
            'parcel' => $parameters,
        ]);

        return $this->apiClient->request('POST', 'parcels', $request);
    }

    public function shortPickItems(array $parameters): OneStockResponse
    {
        $request = Invoke::new(ShortPickRequest::class, $parameters);

        return $this->apiClient->request('PATCH', 'shortpick_line_items', $request);
    }
}
