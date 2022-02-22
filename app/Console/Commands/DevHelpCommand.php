<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DevHelpCommand extends Command
{
    protected $signature = 'dev:help';

    protected $description = 'Help for the development environment';

    public function handle(): int
    {
        $this->table(['Requirements'], [
            ['PHP', '>= 8.0'],
            ['Composer', '2.x'],
            ['SQLite', '3'],
            ['Node.js', '>= 12.14.0'],
            ['MailHog', 'https://github.com/mailhog/MailHog'],
        ]);

        $this->table(['Command examples'], [
            ['php artisan dev:help'],
            ['php artisan route:list'],
            ['php artisan serve'],
            ['php artisan test'],
            ['php artisan dusk'],
            ['php artisan down'],
            ['php artisan up'],
        ]);

        $this->warn("\nNote that MailHog needs to be running for some action.\n".
            'e.g. such as register action, forgot password action and browser testing.');

        return self::SUCCESS;
    }
}
