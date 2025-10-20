<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Backup diario a las 2:00 AM
        $schedule->command('backup:schedule --type=daily --keep=30')
            ->dailyAt('02:00')
            ->timezone('America/Bogota')
            ->withoutOverlapping()
            ->runInBackground();

        // Backup semanal los domingos a las 3:00 AM
        $schedule->command('backup:schedule --type=weekly --keep=90')
            ->weeklyOn(0, '03:00')
            ->timezone('America/Bogota')
            ->withoutOverlapping()
            ->runInBackground();

        // Backup mensual el primer día del mes a las 4:00 AM
        $schedule->command('backup:schedule --type=monthly --keep=365')
            ->monthlyOn(1, '04:00')
            ->timezone('America/Bogota')
            ->withoutOverlapping()
            ->runInBackground();

        // Limpiar logs antiguos semanalmente
        $schedule->command('logs:clear')
            ->weekly()
            ->timezone('America/Bogota');

        // Optimizar base de datos semanalmente
        $schedule->command('db:optimize')
            ->weekly()
            ->timezone('America/Bogota');
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
