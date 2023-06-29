<?php

declare(strict_types=1);

namespace App\Console;

use App\Domain\Trips\Console\DeleteExpiredTripsAndRelatedContentCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(DeleteExpiredTripsAndRelatedContentCommand::class, [30])->dailyAt('3:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/../Domain/Trips/Console');
    }
}
