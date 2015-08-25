<?php namespace UpstatePHP\Website\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->add('events.next', 'NextEventComposer');
        $this->add('partials.menu', 'MenuComposer');
        $this->add('buckets.recent-tweets', 'RecentTweetsComposer');
        $this->add('backend.partials.sidebar-menu', 'AdminMenuComposer');
        $this->add('backend.sponsors.form', 'SponsorTypesComposer');
        $this->add('pages.shell', 'ShellPageComposer');
        $this->add('buckets.recent-video', 'LatestVideoComposer');
        $this->add('backend.events.form', 'SponsorsListComposer');
    }

    protected function add($view, $class)
    {
        $this->app->view->composer($view, '\UpstatePHP\Website\Http\Composers\\'.$class);
    }
} 
