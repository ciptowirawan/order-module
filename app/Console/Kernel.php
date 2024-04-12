<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\OpenRegistrationTask;
use App\Console\Commands\OnsiteRegistrationTask;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan comm
     * ands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\OpenRegistrationTask::class,
        Commands\OnsiteRegistrationTask::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('app:open-registration-task')->cron('00 16 * * *');
        $schedule->command('app:onsite-registration-task')->cron('00 00 2 5 *');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
