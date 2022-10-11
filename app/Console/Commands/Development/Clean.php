<?php

declare(strict_types=1);

namespace App\Console\Commands\Development;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Clean extends Command
{
    protected $signature = 'dev:clean';

    protected $description = 'Clean up development environment';

    private const FILES = [
        // directories
        'node_modules',
        'public/css',
        'public/js',

        // files
        '.env',
        '.env.dusk.local',
        '.phpunit.result.cache',
        'database/app.db',
        'storage/logs/*',
        'storage/framework/sessions/*',
        'storage/framework/testing/*',
        'public/mix-manifest.json'
    ];

    public function handle(): int
    {
        $this->call('dusk:purge');
        $this->call('optimize:clear');

        $command = 'rm -rf '.implode(' ', self::FILES);
        Process::fromShellCommandline($command)->run();

        $this->info('Clean up completed.');

        return self::SUCCESS;
    }
}
