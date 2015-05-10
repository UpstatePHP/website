<?php
namespace UpstatePHP\Website\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;

class Frontend
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
        $this->asset->style('google-font', '//fonts.googleapis.com/css?family=Droid+Sans+Mono');
        $this->asset->style('template', 'css/app.min.css', 'google-font');
        $this->asset->container('before-footer')->script('google-maps', '//maps.google.com/maps/api/js?sensor=true');
        $this->asset->container('before-footer')->script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js');
        $this->asset->container('footer')->script('main', 'js/main.min.js', ['jquery']);
    }

    private function registerMenu()
    {
        $menu = $this->app->make('menu');

        $menu->put('sponsors', [
            'route' => 'page.sponsors',
            'order' => 2,
            'icon' => 'star'
        ]);
    }

}
