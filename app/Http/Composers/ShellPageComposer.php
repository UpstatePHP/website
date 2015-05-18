<?php
namespace UpstatePHP\Website\Http\Composers;

use Michelf\Markdown;

class ShellPageComposer
{
    public function compose($view)
    {
        $view->pageHeader = $view->pageTitle = $view->page->title;
        $view->bodyContent = Markdown::defaultTransform($view->page->content);
    }
}
