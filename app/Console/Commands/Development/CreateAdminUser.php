<?php

declare(strict_types=1);

namespace App\Console\Commands\Development;

use App\Groups\Admin\AdminUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Hashing\HashManager;

class CreateAdminUser extends Command
{
    private const ADMIN_NAME = 'admin';
    private const ADMIN_EMAIL = 'admin@example.com';

    protected $signature = 'dev:create-admin-user';

    protected $description = 'Create an admin user';

    public function handle(
        AdminUser $adminUser,
        HashManager $hash,
    ): int {
        /** @var AdminUser $query */
        $query = $adminUser::query();

        if ($query->byEmail(self::ADMIN_EMAIL)->exists()) {
            $this->error('Admin user has already been created.');

            return self::FAILURE;
        }

        $adminUser = new AdminUser();
        $adminUser->name = self::ADMIN_NAME;
        $adminUser->email = self::ADMIN_EMAIL;
        $adminUser->email_verified_at = new Carbon();
        $adminUser->password = $hash->make(str_repeat(self::ADMIN_NAME, 2));
        $adminUser->save();

        $this->info('An admin user has been created.');

        return self::SUCCESS;
    }
}
