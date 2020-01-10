<?php

namespace Inviqa\OneStock\Parcel;

use DTL\Invoke\Invoke;

class ParcelCreateRequest
{
    /**
     * @var string
     */
    public $site_id;

    public $parcel;

    public function __construct(string $site_id, array $parcel)
    {
        $this->site_id = $site_id;
        $this->parcel = Invoke::new(ParcelCreate::class, $parcel);
    }
}
