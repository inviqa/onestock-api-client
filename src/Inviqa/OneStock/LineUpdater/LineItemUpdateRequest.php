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

    /**
     * @var array
     */
    private $items;

    /**
     * @var array
     */
    private $information;

    public function __construct(string $site_id, array $items, array $information = [])
    {
        $this->site_id = $site_id;
        $this->ids = array_map(function (array $item) {
            return $item['id'];
        }, $items);
        $this->bodies = array_map(function (array $item) {
            unset($item['id']);

            return Invoke::new(LineItemBody::class, ['item' => $item]);
        }, $items);
        $this->items = $items;
        $this->information = $information;
    }
}
