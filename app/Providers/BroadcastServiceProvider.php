<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;

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


        //require base_path('routes/channels.php');
        Broadcast::channel('fixture.{fixtureId}', function ($user, $fixtureId) {
            return true;
        });


    }
}
