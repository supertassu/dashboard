<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        Broadcast::channel('dashboard', function (User $user) {
            return true;
        });
    }
}
