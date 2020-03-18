<?php

namespace App\Http\Controllers;

use App\Services\GoogleFitService;
use App\Services\FoldingStatsService;
use App\Services\ScheduleService;

class InitialValueController extends Controller
{
    public function fitness()
    {
        return GoogleFitService::getOrFetch();
    }

    public function folding()
    {
        return FoldingStatsService::getOrFetch();
    }

    public function schedule()
    {
        return ['schedule' => ScheduleService::getOrFetch()];
    }
}
