<?php

namespace Inviqa\OneStock\Order\Request;

use Inviqa\OneStock\Entity\Order;

class JsonRequest
{
    public $site_id;
    public $order;

    /**
     * JsonRequest constructor.
     *
     * @param $site_id
     * @param $order
     */
    public function __construct(string $site_id, Order $order)
    {
        $this->site_id = $site_id;
        $this->order = $order;
    }
}
