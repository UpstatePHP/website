<?php namespace UpstatePHP\Website\Http\Controllers;

use UpstatePHP\Website\Sponsor as Sponsor;

class HomeController extends Controller
{

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
        $menu = (object)[];

        $tweets = \Twitter::getUserTimeline([
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
