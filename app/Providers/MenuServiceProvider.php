<?php namespace UpstatePHP\Website\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('menu', function()
        {
            return new Collection;
        });

        $this->app->singleton('admin-menu', function()
        {
            return new Collection;
        });
    }
}