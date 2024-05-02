<?php

declare(strict_types=1);

namespace App\Console\Commands\Development;

use App\Groups\Admin\AdminUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Hashing\HashManager;

class CreateAdminUser extends Command
{
    private const ADMIN_USER_NAME = 'admin';
    private const ADMIN_USER_EMAIL = 'admin@example.com';
    private const ADMIN_USER_PASSWORD = 'adminadmin';

    protected $signature = 'dev:create-admin-user';

    protected $description = 'Create an admin user';

    public function handle(AdminUser $adminUser, HashManager $hash, Carbon $carbon): int
    {
        /** @var AdminUser $query */
        $query = $adminUser::query();

        if ($query->byEmail(self::ADMIN_USER_EMAIL)->exists()) {
            $this->error('Admin user has already been created.');

            return self::FAILURE;
        }

        $adminUser->name = self::ADMIN_USER_NAME;
        $adminUser->email = self::ADMIN_USER_EMAIL;
        $adminUser->email_verified_at = $carbon::now();
        $adminUser->password = $hash->make(self::ADMIN_USER_PASSWORD);
        $adminUser->save();

        $this->info('An admin user has been created.');

        return self::SUCCESS;
    }
}
