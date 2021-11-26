<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            $this->createWebGroups([
                'admin',
                'auth',
                'users',
                'papers',

                // site has fallback
                'site',
            ]);
        });
    }

    protected function createWebGroups(array $groups): void
    {
        foreach ($groups as $group) {
            Route::prefix($group === 'site' || $group === 'auth' ? '' : $group)
                ->middleware('web')
                ->group(base_path('routes/web/'.$group.'.php'));
        }
    }
}
