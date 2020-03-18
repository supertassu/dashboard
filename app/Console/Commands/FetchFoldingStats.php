<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FoldingStatsService;

class FetchFoldingStats extends Command
{
    protected $signature = 'dashboard:fetch-folding';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        FoldingStatsService::fetch();
    }
}
