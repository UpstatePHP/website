<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;

class Backend
{
    protected $asset;

    public function __construct(Application $app)
    {
        $this->asset = $app->make('orchestra.asset');
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

		return $next($request);
	}

    private function registerAssets()
    {
        $this->asset->style('admin', 'css/admin.min.css');
        $this->asset->container('footer')->script('admin', 'js/admin.min.js', ['jquery']);
    }

}
