<?php

namespace Inviqa\OneStock\LineUpdater;

use DTL\Invoke\Invoke;
use Inviqa\OneStock\Entity\ShortPickedLineItem;

class ShortPickRequest
{
    public $order_id;

    public $line_items;

    public function __construct(string $order_id, array $line_items)
    {
        $this->order_id = $order_id;
        $this->line_items = array_map(function ($item) {
            return Invoke::new(ShortPickedLineItem::class, $item);
        }, $line_items);
    }
}
