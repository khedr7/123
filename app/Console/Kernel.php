<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\RenameVideo;
use App\Console\Commands\ReplaceFiles;
use App\Console\Commands\StartCourseMail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Torann\Currency\Console\Update::class,
        \Torann\Currency\Console\Cleanup::class,
        \Torann\Currency\Console\Manage::class,
        RenameVideo::class,
        Commands\DatabaseBackUp::class,
        ReplaceFiles::class,
        'App\Console\Commands\StartCourseMail'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();


        $schedule->command('startMail:courses')->daily();
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
