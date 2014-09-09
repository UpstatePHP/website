<?php namespace UpstatePHP\Website\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->add('events.next', 'NextEventComposer');
        $this->add(['events.admin.create', 'events.admin.edit'], 'VenueListComposer');
    }

    protected function add($view, $class)
    {
        $this->app->view->composer($view, '\UpstatePHP\Website\Composers\\'.$class);
    }
} 