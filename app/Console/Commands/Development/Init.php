<?php

declare(strict_types=1);

namespace App\Console\Commands\Development;

use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

class Init extends Command
{
    protected $signature = 'dev:init';

    protected $description = 'Prepare the project for the development environment';

    public function handle(Filesystem $file): int
    {
        /** @var Application $app */
        $app = $this->laravel;

        $file->copy('.env.example', '.env');
        $file->copy('.env.dusk.local.example', '.env.dusk.local');

        $file->put($app->databasePath('app.db'), '');
        $file->put($app->storagePath('framework/testing/app.db'), '');

        $envFilename = $app->environmentFilePath();

        $generateAppKey = fn () => 'base64:'.base64_encode(
            Encrypter::generateKey($app['config']['app']['cipher']),
        );

        // .env
        $data = $file->get($envFilename);
        $data = preg_replace('/__app_key__/', $generateAppKey(), $data);
        $data = preg_replace('/__database__/', $app->databasePath('app.db'), $data);
        $file->put($envFilename, $data);

        // .env.dusk.local
        $data = $file->get($envFilename.'.dusk.local');
        $data = preg_replace('/__app_key__/', $generateAppKey(), $data);
        $data = preg_replace('/__database__/', $app->storagePath('framework/testing/app.db'), $data);
        $file->put($envFilename.'.dusk.local', $data);

        $this->call('migrate', ['--force' => true]);
        $this->call('dev:create-admin-user');
        $this->call('dusk:chrome-driver');

        $this->info('The development environment is ready.');

        $this->call('dev:help');

        return self::SUCCESS;
    }
}
