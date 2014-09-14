<?php namespace UpstatePHP\Website\Composers;

use UpstatePHP\Website\Models;

class VenueListComposer
{
    public function compose($view)
    {
        $venues = isset($view->venues) ? $view->venues : Models\Venue::all();

        $list = [];

        foreach ($venues as $venue) {
            $list[$venue->id] = $venue->name;
        }

        $view->venues = $list;
    }
}