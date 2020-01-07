<?php

namespace Inviqa\OneStock\LineUpdater;

use DTL\Invoke\Invoke;
use Inviqa\OneStock\Entity\LineItemBody;

class LineItemUpdateRequest
{
    /**
     * @var string
     */
    public $site_id;

    /**
     * @var array
     */
    public $ids;

    /**
     * @var LineItemBody[]
     */
    public $bodies;

    public function __construct(string $site_id, array $items)
    {
        $this->site_id = $site_id;
        $this->ids = array_map(function (array $item) {
            return $item['item_id'];
        }, $items);
        $this->bodies = array_map(function (array $item) {
            unset($item['item_id']);

            return Invoke::new(LineItemBody::class, ['item' => $item]);
        }, $items);
    }
}
