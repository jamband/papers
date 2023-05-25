<?php

declare(strict_types=1);

namespace App\Console\Commands\Development;

use Illuminate\Console\Command;

class Help extends Command
{
    protected $signature = 'dev:help';

    protected $description = 'Help for the development environment';

    public function handle(): int
    {
        $this->table(['Requirements'], [
            ['PHP', '>= 8.1'],
            ['Composer', '>= 2.2.0'],
            ['SQLite', '3'],
            ['Node.js', '>= 18.x'],
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
            ['npm run dev'],
            ['npm run build'],
        ]);

        $this->warn("\nNote that MailHog needs to be running for some action.\n".
            'e.g. such as register action, forgot password action and browser testing.');

        return self::SUCCESS;
    }
}
