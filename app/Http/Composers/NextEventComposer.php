<?php
namespace UpstatePHP\Website\Http\Composers;

use Carbon\Carbon;
use Michelf\Markdown;
use UpstatePHP\Website\Domain\Events\EventRepository;

class NextEventComposer
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function compose($view)
    {
        $next = $this->eventRepository->nextEvent();

        if (! is_null($next)) {
            $view->nextEvent = null;
            $eventLocation = json_encode([
                'latitude' => $next->latitude,
                'longitude' => $next->longitude,
                'name' => $next->location_name,
                'popup' => sprintf('<h5>UpstatePHP @ %s</h5><p>%s<br>%s</p>',
                    $next->location_name,
                    $next->street,
                    trim($next->city . ' ' . $next->state . ' ' . $next->zipcode)
                )
            ]);

            $view->nextEvent = (object) [
                'title' => $next->title,
                'startDate' => $next->begins_at->format('m/d'),
                'startTime' => $next->begins_at->format('g:ia'),
                'registration_link' => $next->registration_link,
                'eventLocation' => $eventLocation,
                'location_name' => $next->location_name,
                'description' => Markdown::defaultTransform($next->description)
            ];
        } else {
            $view->nextEvent = null;
            $view->nextScheduledEvent = (new Carbon('third thursday of next month'))->format('n/d') . ' @ 6pm';
        }

    }
}
