<?php namespace UpstatePHP\Website\Providers;

use Illuminate\Support\ServiceProvider;

class HostedEventServiceProvider extends ServiceProvider
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
        $this->app->bind('\UpstatePHP\Website\Domain\Events\EventRepository', function(){
            return $this->app->make('\UpstatePHP\Website\Domain\Events\Providers\EventbriteProvider');
        });
    }

}