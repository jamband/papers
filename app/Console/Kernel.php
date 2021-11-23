<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /** @var array */
    protected $commands = [
    ];

    /**
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('auth:clear-resets')->everyFifteenMinutes();
    }

    /**
     * @return void
     */
    protected function commands():void
    {
        $this->load(__DIR__.'/Commands');
    }
}
