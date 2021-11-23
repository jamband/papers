<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Init extends Migration
{
    private const ADMIN_USERS_TABLE = 'admin_users';
    private const USERS_TABLE = 'users';
    private const PASSWORD_RESETS_TABLE = 'password_resets';
    private const PAPERS_TABLE = 'papers';

    public function up(): void
    {
        Schema::create(self::ADMIN_USERS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create(self::USERS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create(self::PASSWORD_RESETS_TABLE, function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create(self::PAPERS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->string('body');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on(self::USERS_TABLE)
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::ADMIN_USERS_TABLE);
        Schema::dropIfExists(self::USERS_TABLE);
        Schema::dropIfExists(self::PASSWORD_RESETS_TABLE);
        Schema::dropIfExists(self::PAPERS_TABLE);
    }
}
