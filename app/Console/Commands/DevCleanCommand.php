<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

/**
 * @noinspection PhpUnused
 */
class DevCleanCommand extends Command
{
    /** @var string */
    protected $signature = 'dev:clean';

    /** @var string */
    protected $description = 'Clean up development environment';

    /** @var string[] */
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

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->call('optimize:clear');

        $command = 'rm -rf '.implode(' ', self::FILES);
        Process::fromShellCommandline($command)->run();

        $this->info('Clean up completed.');

        return self::SUCCESS;
    }
}
