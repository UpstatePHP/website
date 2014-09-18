<?php namespace UpstatePHP\Website\Composers;

use UpstatePHP\Website\Models;
use Michelf\Markdown;

class NextEventComposer
{
    public function compose($view)
    {
        $next = Models\Event::next();

        if (is_null($next)) {
            $view->nextEvent = null;
            return;
        }

        $venueConfig = json_encode([
            'latitude' => $next->venue->latitude,
            'longitude' => $next->venue->longitude,
            'name' => $next->venue->name,
            'popup' => sprintf('<h5>UpstatePHP @ %s</h5><p>%s<br>%s</p>',
                $next->venue->name,
                $next->venue->street,
                trim($next->venue->city . ' ' . $next->venue->state . ' ' . $next->venue->zipcode)
            )
        ]);

        $view->nextEvent = (object) [
            'startDate' => $next->begins_at->format('m/d'),
            'startTime' => $next->begins_at->format('g:ia'),
            'registration_link' => $next->registration_link,
            'venue' => $next->venue,
            'venueConfig' => $venueConfig,
            'description' => Markdown::defaultTransform($next->description)
        ];
    }
} 