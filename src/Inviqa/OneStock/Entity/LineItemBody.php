<?php

namespace Inviqa\OneStock\Entity;

use DTL\Invoke\Invoke;

class LineItemBody
{
    /**
     * @var UpdatedLineItem
     */
    public $line_item;

    public function __construct(array $item)
    {
        if (isset($item['payment']['price'])) {
            $item['payment']['price'] = (float) $item['payment']['price'];
            $item['payment'] = Invoke::new(ItemPayment::class, $item['payment']);
        }

        if (isset($item['delivery'])) {
            if (isset($item['delivery']['carrier'])) {
                $item['delivery']['carrier'] = Invoke::new(ShippingCarrier::class, $item['delivery']['carrier']);
            }
            $item['delivery'] = Invoke::new(ItemDelivery::class, $item['delivery']);
        }

        $this->line_item = Invoke::new(UpdatedLineItem::class, $item);
    }
}
