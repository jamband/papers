<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\AdminUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

/**
 * @noinspection PhpUnused
 */
class DevCreateAdminUserCommand extends Command
{
    /** @var string */
    private const ADMIN_EMAIL = 'admin@example.com';

    /** @var string */
    protected $signature = 'dev:create-admin-user';

    /** @var string */
    protected $description = 'Create an admin user';

    /**
     * @return int
     */
    public function handle(): int
    {
        if ($this->userAlreadyExists()) {
            $this->error('Admin user has already been created.');

            return self::FAILURE;
        }

        $adminUser = new AdminUser;
        $adminUser->name = 'admin';
        $adminUser->email = self::ADMIN_EMAIL;
        $adminUser->email_verified_at = now();
        $adminUser->password = Hash::make(str_repeat($adminUser->name, 2));
        $adminUser->save();

        $this->info('An admin user has been created.');

        return self::SUCCESS;
    }

    /**
     * @return bool
     */
    private function userAlreadyExists(): bool
    {
        /** @var AdminUser $query */
        $query = AdminUser::query();

        return $query->byEmail(self::ADMIN_EMAIL)->exists();
    }
}
