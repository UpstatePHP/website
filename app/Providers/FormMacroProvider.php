<?php
namespace UpstatePHP\Website\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;

class FormMacroProvider extends ServiceProvider
{
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        \Form::macro('states', function($name, $selected, $attributes)
        {
            return \Form::select($name, \Config::get('states'), $selected, $attributes);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }


}