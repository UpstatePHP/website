<?php namespace App\Providers;

/**
 * Created as per http://laravel.com/docs/5.0/views
 */

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

	/**
	 * Register bindings in the container. 
	 *
	 * @return void
	 */
	public function boot()
	{
	  View::composer('index', 'App\Http\ViewComposers\RecentTweetsComposer');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
