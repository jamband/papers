<?php

declare(strict_types=1);

namespace App\Console\Commands\Development;

use App\Groups\Admin\AdminUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    private const ADMIN_EMAIL = 'admin@example.com';

    protected $signature = 'dev:create-admin-user';

    protected $description = 'Create an admin user';

    public function handle(): int
    {
        if ($this->userAlreadyExists()) {
            $this->error('Admin user has already been created.');

            return self::FAILURE;
        }

        $adminUser = new AdminUser;
        $adminUser->name = 'admin';
        $adminUser->email = self::ADMIN_EMAIL;
        $adminUser->email_verified_at = new Carbon();
        $adminUser->password = Hash::make(str_repeat($adminUser->name, 2));
        $adminUser->save();

        $this->info('An admin user has been created.');

        return self::SUCCESS;
    }

    private function userAlreadyExists(): bool
    {
        /** @var AdminUser $query */
        $query = AdminUser::query();

        return $query->byEmail(self::ADMIN_EMAIL)->exists();
    }
}
