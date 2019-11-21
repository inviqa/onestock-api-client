<?php

namespace Inviqa\OneStock\Order;

use Inviqa\OneStock\OneStockResponse;

class OrderExporter
{
    public function export(): OneStockResponse
    {
        return new OneStockResponse();
    }
}
