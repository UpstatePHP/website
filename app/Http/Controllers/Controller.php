<?php namespace UpstatePHP\Website\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Orchestra\Support\Facades\Asset as Asset;

abstract class Controller extends BaseController
{

    use DispatchesCommands, ValidatesRequests;

    /*
     * Set up assets common to all pages.
     */
    protected function setupAssets()
    {
        Asset::container('in-header')
            ->style('appcss', 'css/app.css')
            ->script('google-font', '//fonts.googleapis.com/css?family=Droid+Sans+Mono')
            ->style('plugins', 'css/plugins.min.css', 'google-font')
            ->style('template', 'css/template.min.css', ['google-font', 'plugins']);

        Asset::container('before-footer')
            ->script('google-maps', '//maps.google.com/maps/api/js?sensor=true')
            ->script('jquery',
                '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js');

        Asset::container('footer')
            ->script('plugins', 'js/plugins.min.js', 'jquery')
            ->script('main', 'js/main.min.js', ['jquery', 'plugins']);
    }
}
