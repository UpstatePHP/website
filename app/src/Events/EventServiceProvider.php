<?php namespace UpstatePHP\Website\Events;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepository();
    }

    private function registerRepository()
    {
        $this->app->bind('\UpstatePHP\Website\Events\EventRepository', function(){
            return $this->app->make('\UpstatePHP\Website\Events\Providers\EventbriteProvider');
        });
    }

}