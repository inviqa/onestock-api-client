<?php

namespace Inviqa\OneStock\Parcel;

use DTL\Invoke\Invoke;
use Inviqa\OneStock\Entity\ItemDelivery;
use Inviqa\OneStock\Entity\ItemPayment;
use Inviqa\OneStock\Entity\LineItem;
use Inviqa\OneStock\Entity\ShippingCarrier;

class ParcelCreateRequest
{
    /**
     * @var string
     */
    public $site_id;

    public function __construct(string $site_id, array $parcel)
    {
        $this->site_id = $site_id;
        $this->parcel = Invoke::new(ParcelCreate::class, $parcel);
    }
}
