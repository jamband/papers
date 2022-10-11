<?php

declare(strict_types=1);

namespace App\Console\Commands\Development;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class Init extends Command
{
    protected $signature = 'dev:init';

    protected $description = 'Prepare the project for the development environment';

    public function __construct(
        private Filesystem $file,
        private Repository $config,
    ) {
        parent::__construct();
    }

    /**
     * @throws FileNotFoundException
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
     * @throws FileNotFoundException
     */
    private function prepareEnvironmentFile(): void
    {
        $envFilename = $this->laravel->environmentFilePath();

        // .env
        $data = $this->file->get($envFilename);
        $data = preg_replace('/__app_key__/', $this->generateAppKey(), $data);
        $data = preg_replace('/__database__/', database_path('app.db'), $data);
        $this->file->put($envFilename, $data);

        // .env.dusk.local
        $data = $this->file->get($envFilename.'.dusk.local');
        $data = preg_replace('/__app_key__/', $this->generateAppKey(), $data);
        $data = preg_replace('/__database__/', storage_path('framework/testing/app.db'), $data);
        $this->file->put($envFilename.'.dusk.local', $data);
    }

    private function generateAppKey(): string
    {
        return 'base64:'.base64_encode(
            Encrypter::generateKey($this->config->get('app.cipher'))
        );
    }
}
