<?php
namespace UpstatePHP\Website\Http\Composers;

use Cache;

class ShellPageComposer
{
    public function compose($view)
    {
        $view->pageHeader = $view->pageTitle = $view->page->title;
        $view->bodyContent = Cache::get($view->page->path);
    }
}
