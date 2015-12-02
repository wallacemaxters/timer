<?php

namespace WallaceMaxters\Timer\Laravel;

use Illuminate\Support\ServiceProvider;

use WallaceMaxters\Timer\Time;

class TimeServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('time', function()
        {
            return new Time(0, 0, 0);
        });
    }

}