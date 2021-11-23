<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * @noinspection PhpUnused
 */
class DevInitCommand extends Command
{
    /** @var string */
    protected $signature = 'dev:init';

    /** @var string */
    protected $description = 'Prepare the project for the development environment';

    private Filesystem $file;

    /**
     * @param Filesystem $file
     */
    public function __construct(Filesystem $file)
    {
        parent::__construct();

        $this->file = $file;
    }

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->file->copy('.env.example', '.env');
        $this->file->copy('.env.dusk.local.example', '.env.dusk.local');

        $this->file->put(database_path('app.db'), '');
        $this->file->put(storage_path('framework/testing/app.db'), '');

        $this->prepareEnvironmentFile();

        $this->call('migrate', [
            '--force' => true,
            '--seed' => true,
        ]);

        $this->call('dev:create-admin-user');
        $this->call('dusk:chrome-driver');

        $this->info("The development environment is ready.");

        $this->call('dev:help');

        return self::SUCCESS;
    }

    /**
     * @return void
     */
    private function prepareEnvironmentFile(): void
    {
        $envFilename = $this->laravel->environmentFilePath();

        // .env
        $source = file_get_contents($envFilename);
        $data = preg_replace('/__database__/', base_path().'/database/app.db', $source);
        file_put_contents($envFilename, $data);

        // .env.dusk.local
        $source = file_get_contents($envFilename.'.dusk.local');
        $data = preg_replace('/__database__/', base_path().'/storage/framework/testing/app.db', $source);
        file_put_contents($envFilename.'.dusk.local', $data);
    }
}
