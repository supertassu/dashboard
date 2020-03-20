<?php

namespace App\Providers;

use App\User;
use App\Auth\AdfsSocialiteDriver;
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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $this->registerPolicies();

        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'adfs',
            function ($app) use ($socialite) {
                $config = [
                    'client_id' => env('ADFS_CLIENT_ID'),
                    'client_secret' => env('ADFS_CLIENT_SECRET'),
                    'redirect' => url(route('login.callback')),
                ];

                return $socialite->buildProvider(AdfsSocialiteDriver::class, $config);
            }
        );
    }
}
