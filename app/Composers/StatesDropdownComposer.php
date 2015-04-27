<?php namespace UpstatePHP\Website\Composers;

class StatesDropdownComposer
{
    public function compose($view)
    {
        $view->states = \Config::get('states');
    }
}