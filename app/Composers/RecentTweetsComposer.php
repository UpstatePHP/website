<?php namespace UpstatePHP\Website\Composers;

class RecentTweetsComposer
{
    public function compose($view)
    {
        $view->tweets = $view->app->cache->remember('tweets', 60, function() use ($view)
        {
            $tweets = $view->app->make('ttwitter')->getUserTimeline([
                'screen_name' => $view->app->config->get('site-config.twitter-username'),
                'count' => 2
            ]);
            return ! is_null($tweets) ? $tweets : $view->app->cache->get('tweets', []);
        });
    }
}