<?php

namespace spec\Inviqa\OneStock;

use Inviqa\OneStock\Application;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Application
 */
class ApplicationSpec extends ObjectBehavior
{
    function it_can_export_an_order()
    {
        $this->exportOrder([]);
    }
}
