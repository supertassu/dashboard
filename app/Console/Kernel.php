<?php

namespace App\Console;

use App\Console\Commands\FetchSchedule;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\FetchFoldingStats;
use App\Console\Commands\FetchGoogleFitStats;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(FetchGoogleFitStats::class)
            ->everyFiveMinutes();

        $schedule->command(FetchFoldingStats::class)
            ->everyTenMinutes();

        $schedule->command(FetchSchedule::class)
            ->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
