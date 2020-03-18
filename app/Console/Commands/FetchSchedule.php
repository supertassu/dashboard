<?php

namespace App\Console\Commands;

use App\Services\ScheduleService;
use Illuminate\Console\Command;

class FetchSchedule extends Command
{
    protected $signature = 'dashboard:fetch-schedule';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        ScheduleService::fetch();
    }
}
