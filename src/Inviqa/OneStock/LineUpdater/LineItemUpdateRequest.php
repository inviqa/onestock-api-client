<?php

namespace Inviqa\OneStock\LineUpdater;

use DTL\Invoke\Invoke;
use Inviqa\OneStock\Entity\ItemPayment;
use Inviqa\OneStock\Entity\LineItem;

class LineItemUpdateRequest
{
    /**
     * @var string
     */
    public $site_id;

    /**
     * @var LineItem[]
     */
    public $items;

    public function __construct(string $site_id, array $items)
    {
        $this->site_id = $site_id;
        $this->items = array_map(function (array $item) {
            if (isset($item['payment']['price'])) {
                $item['payment']['price'] = (float) $item['payment']['price'];
            }
            $item['payment'] = Invoke::new(ItemPayment::class, $item['payment']);

            return Invoke::new(LineItem::class, $item);
        }, $items);
    }
}
