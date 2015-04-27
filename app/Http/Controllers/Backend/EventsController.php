<?php
namespace UpstatePHP\Website\Http\Controllers\Backend;

use UpstatePHP\Website\Domain\Events\EventRepository;
use UpstatePHP\Website\Http\Controllers\Controller;

class EventsController extends Controller
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        $data = [
            'pageHeader' => 'Events',
            'events' => $this->eventRepository->allEvents(20)
        ];

        return view('backend.events.index', $data);
    }
}