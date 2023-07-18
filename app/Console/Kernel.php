<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    // protected $commands = [
    //     \App\Console\Command\DownloadFDRS::class,
    //     \App\Console\Command\DownloadForecast::class,
    //     \App\Console\Command\DownloadHotspot::class,
    //     \App\Console\Command\DownloadWeather::class,
    //     \App\Console\Command\UpdateVolcano::class
    // ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('hotspot:download')->hourly();
        $schedule->command('fdrs:download')->hourly();
        $schedule->command('forecast:download')->everyThreeHours();
        $schedule->command('volcano:update')->hourly(); 
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
