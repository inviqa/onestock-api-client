<?php

namespace Inviqa\OneStock\Parcel;

class ParcelCreate
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var int
     */
    public $date;

    /**
     * @var string
     */
    public $to;

    /**
     * @var string
     */
    public $order_id;

    /**
     * @var array
     */
    public $line_item_ids;

    /**
     * @var string
     */
    public $tracking_code;

    public function __construct(
        $order_id,
        string $id = null,
        int $date = null,
        string $to = null,
        array $line_item_ids = [],
        string $tracking_code = null
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->to = $to;
        $this->order_id = (string) $order_id;
        $this->line_item_ids = $line_item_ids;
        $this->tracking_code = $tracking_code;
    }
}
