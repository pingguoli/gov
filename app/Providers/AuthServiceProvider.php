<?php

namespace App\Providers;

use App\Model\Admin;
use App\Model\Role;
use App\Model\Team;
use App\Policies\AdminPolicy;
use App\Policies\RolePolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Admin::class => AdminPolicy::class,
        Role::class => RolePolicy::class,
        Team::class => TeamPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
