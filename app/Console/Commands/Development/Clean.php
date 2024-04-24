<?php

declare(strict_types=1);

namespace App\Console\Commands\Development;

use Illuminate\Console\Command;
use Illuminate\Process\PendingProcess;

class Clean extends Command
{
    protected $signature = 'dev:clean';

    protected $description = 'Clean up development environment';

    private const FILES = [
        // directories
        '.phpunit.cache',
        'node_modules',
        'public/build',

        // files
        '.env',
        '.env.dusk.local',
        '.phpunit.result.cache',
        'database/app.db',
        'storage/logs/*',
        'storage/framework/sessions/*',
        'storage/framework/testing/*',
    ];

    public function handle(
        PendingProcess $process,
    ): int {
        $this->call('dusk:purge');
        $this->call('optimize:clear');

        $process->run('rm -rf '.implode(' ', self::FILES));

        $this->info('Clean up completed.');

        return self::SUCCESS;
    }
}
