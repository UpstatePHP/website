<?php namespace UpstatePHP\Website\Composers;

class RecentTweetsComposer
{
    public function compose($view)
    {
        $view->tweets = $view->app->cache->remember('tweets', 60, function() use ($view)
        {
            return $view->app->make('ttwitter')->getUserTimeline([
                'screen_name' => $view->app->config->get('site-config.twitter-username'),
                'count' => 3
            ]);
        });
    }
}