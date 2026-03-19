<?php

declare(strict_types=1);

namespace App\Console\Commands\Development;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Process\PendingProcess;

#[Signature('dev:clean')]
#[Description('Clean up development environment')]
class Clean extends Command
{
    /** @var array<int, string> */
    private const array FILES = [
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
        'storage/framework/testing/*',
    ];

    public function handle(PendingProcess $process): int
    {
        $this->call('dusk:purge');
        $this->call('optimize:clear');

        $process->run('rm -rf '.implode(' ', self::FILES));

        $this->info('Clean up completed.');

        return self::SUCCESS;
    }
}
