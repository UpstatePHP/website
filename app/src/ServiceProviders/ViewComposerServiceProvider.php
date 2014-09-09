<?php namespace UpstatePHP\Website\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->add('events.next', 'NextEventComposer');
        $this->add(['events.admin.create', 'events.admin.edit'], 'VenueListComposer');
        $this->add('partials.menu', 'MenuComposer');
        $this->add(['venues.admin.create', 'venues.admin.edit'], 'StatesDropdownComposer');
    }

    protected function add($view, $class)
    {
        $this->app->view->composer($view, '\UpstatePHP\Website\Composers\\'.$class);
    }
} 