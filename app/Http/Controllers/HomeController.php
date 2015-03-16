<?php namespace App\Http\Controllers;

use Thujohn\Twitter\TwitterFacade as Twitter;
use App\Sponsor as Sponsor;
use Orchestra\Support\Facades\Asset as Asset;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
//		$this->middleware('auth');
    parent::setupAssets();
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
    $menu = (object) [];

    $tweets = Twitter::getUserTimeline([
        'screen_name' => 'johnroberstorey',
        'count' => 3,
        'format' => 'object'
      ]
    );

    $supporters = Sponsor::get()->take(4);

    return view('index')
      ->withTweets($tweets)
      ->withSupporters($supporters)
      ->withMenu($menu);

	}

}
