<?php

namespace App\Events;

class FitDataFetched extends DashboardEvent
{
    /** @var int */
    public $steps, $sleep;

    public function __construct(int $steps, int $sleep)
    {
        $this->steps = $steps;
        $this->sleep = $sleep;
    }
}
