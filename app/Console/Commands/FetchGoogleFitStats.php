<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoogleFitService;
use App\Services\FoldingStatsService;

class FetchGoogleFitStats extends Command
{
    protected $signature = 'dashboard:fetch-google-fit';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        GoogleFitService::fetch();
    }
}
