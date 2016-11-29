<?php

namespace App\Console;

use App\Console\Commands\GetDiskSpace;
use App\Console\Commands\UserAdd;
use App\Console\Commands\UserDelete;
use App\Console\Commands\UserList;
use App\Console\Commands\UserSetPassword;
use App\Console\Commands\UserSetRoles;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UserAdd::class,
        GetDiskSpace::class,
        UserSetRoles::class,
        UserSetPassword::class,
        UserDelete::class,
        UserList::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('diskspace:get')->everyTenMinutes();
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
