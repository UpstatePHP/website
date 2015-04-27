<?php namespace UpstatePHP\Website\ServiceProviders;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bindShared('menu', function()
        {
            return new Collection;
        });
    }
}