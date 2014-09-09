<?php namespace UpstatePHP\Website\Composers;

use UpstatePHP\Website\Models;

class NextEventComposer
{
    public function compose($view)
    {
        $next = Models\Event::next();

        $view->nextEvent = (object) [
            'startDate' => $next->begins_at->format('m/d'),
            'startTime' => $next->begins_at->format('H:i'),
            'link' => $next->link,
            'venue' => ''
        ];
    }
} 