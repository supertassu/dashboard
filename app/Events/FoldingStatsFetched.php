<?php

namespace App\Events;

use DateTime;

class FoldingStatsFetched extends DashboardEvent
{
    /** @var array */
    public $folding;

    /** @var DateTime */
    public $at;

    public function __construct(array $folding)
    {
        $this->folding = $folding;
        $this->at = now();
    }
}
