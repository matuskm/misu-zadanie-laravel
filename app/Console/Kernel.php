<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\EshopsUpdateData::class,
        Commands\EmailSendNotification::class
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Run the task every day at midnight
        $schedule->command('eshop-action:update')->timezone( config('app.timezone') )->daily()->withoutOverlapping()->runInBackground();
        // Run the task every day at 7:30 AM
        $schedule->command('email:send-notification')->timezone( config('app.timezone') )->dailyAt( '07:30' )->withoutOverlapping()->runInBackground();
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
