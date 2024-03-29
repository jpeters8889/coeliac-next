<?php

declare(strict_types=1);

namespace Jpeters8889\PrintAllOrders;

use Laravel\Nova\Card;

class PrintAllOrders extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    public $height = 'dynamic';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'print-all-orders';
    }
}
