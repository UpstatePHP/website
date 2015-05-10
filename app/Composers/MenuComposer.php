<?php namespace UpstatePHP\Website\Composers;

use UpstatePHP\Website\Models;

class MenuComposer
{
    public function compose($view)
    {
        $view->menu = $view->app->make('menu');
    }
} 