<?php
namespace UpstatePHP\Website\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;

class Backend
{
    protected $asset;
    /**
     * @var Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->asset = $this->app->make('orchestra.asset');
    }

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $this->registerAssets();
        $this->registerMenu();

		return $next($request);
	}

    private function registerAssets()
    {
        $this->asset->style('admin', 'css/admin.min.css');
        $this->asset->container('footer')->script('admin', 'js/admin.min.js', ['jquery']);
    }

    private function registerMenu()
    {
        $menu = $this->app->make('admin-menu');

        $menu->put('dashboard', [
            'route' => 'admin.dashboard',
            'order' => 0,
            'icon' => 'dashboard'
        ]);
        $menu->put('sponsors', [
            'route' => 'admin.sponsors.index',
            'order' => 2,
            'icon' => 'star'
        ]);
//        $menu->put('users', [
//            'link' => '#',
//            'order' => 4,
//            'icon' => 'users'
//        ]);
        $menu->put('events', [
            'route' => 'admin.events.index',
            'order' => 1,
            'icon' => 'calendar'
        ]);
        $menu->put('pages', [
            'route' => 'admin.pages.index',
            'order' => 3,
            'icon' => 'file-text-o'
        ]);
        $menu->put('videos', [
            'route' => 'admin.videos.index',
            'order' => 4,
            'icon' => 'video-camera'
        ]);
    }

}
