<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Userlist;
use App\Models\UserPermission;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Permission::creating(function ($permission) {
            if (empty($permission->guard_name)) {
                $permission->guard_name = 'userlist';
            }
        });
    }
}
