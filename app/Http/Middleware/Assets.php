<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;

class Assets
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
        $this->asset->container('before-footer')->script('google-maps', '//maps.google.com/maps/api/js?sensor=true');
        $this->asset->container('before-footer')->script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js');

        return $next($request);
	}

}
