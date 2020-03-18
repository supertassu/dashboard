<?php

namespace App\Providers;

use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // in order to user private channels a user needs to be logged in
        if (Schema::hasTable(with(new User)->getTable())) {
            if ($user = User::first()) {
                //auth()->login($user);
            }
        }

        auth()->login(new User);

        $this->registerPolicies();
    }
}
