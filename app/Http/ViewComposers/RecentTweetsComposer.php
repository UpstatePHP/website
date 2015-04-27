<?php namespace UpstatePHP\Website\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Users\Repository as UserRepository;

class RecentTweetsComposer {

  /**
   * Bind data to the view.
   *
   * @param View $view
   * @return void
   */
   public function compose(View $view)
{
        //$tweets = $view->app->cache->remember('tweets', 60, function() use ($view)        {
        $tweets = function() use ($view) {
            $tweets = $view->app->make('ttwitter')->getUserTimeline([
                'screen_name' => $view->app->config->get('site-config.twitter-username')
,
                'count' => 2
            ]);
            return ! is_null($tweets) ? $tweets : $view->app->cache->get('tweets', []);
        };

        $view->with('index', $tweets);
    }
}

