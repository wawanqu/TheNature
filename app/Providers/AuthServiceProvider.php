<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Gate: hanya admin & super_admin boleh tambah produk
        Gate::define('manage-products', function ($user) {
            return in_array($user->role, ['admin', 'super_admin']);
        });

        // Gate: admin & super_admin boleh kelola pesanan
        Gate::define('manage-orders', function ($user) {
            return in_array($user->role, ['admin', 'super_admin']);
        });

        // Gate: hanya super_admin boleh kelola role
        Gate::define('manage-roles', function ($user) {
            return $user->role === 'super_admin';
        });
    }
}