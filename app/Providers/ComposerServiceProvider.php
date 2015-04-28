<?php namespace UpstatePHP\Website\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function register()
    {
//        $this->add('events.next', 'NextEventComposer');
//        $this->add('partials.menu', 'MenuComposer');
//        $this->add('sponsors.admin.form', 'SponsorTypesComposer');
//        $this->add('buckets.recent-tweets', 'RecentTweetsComposer');
        $this->add('backend.partials.sidebar-menu', 'AdminMenuComposer');
    }

    protected function add($view, $class)
    {
        $this->app->view->composer($view, '\UpstatePHP\Website\Http\Composers\\'.$class);
    }
} 