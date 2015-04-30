<?php
namespace UpstatePHP\Website\Http\Controllers\Backend;

use UpstatePHP\Website\Domain\Events\Event as EventModel;
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
            'events' => $this->eventRepository->getEvents(20)
        ];

        return view('backend.events.index', $data);
    }

    public function create()
    {
        $data = [
            'pageHeader' => 'Create Event',
            'event' => new EventModel
        ];

        return view('backend.events.form', $data);
    }

    public function edit($id)
    {
        $data = [
            'event' => EventModel::find($id)
        ];
        return view('backend.events.form', $data);
    }
    public function update($id)
    {
        EventModel::find($id)->update(Input::except('_token', '_method'));
        return Redirect::route('admin.events.index');
    }
    public function import()
    {
        $newEvents = $this->eventRepository->importNewRemoteEvents();
        $this->execute(
            '\UpstatePHP\Website\Events\Commands\ImportNewEventsCommand',
            ['events' => $newEvents]
        );
        return Redirect::route('admin.events.index')->with(
            'message',
            sprintf(
                'success::%s new events imported',
                count($newEvents)
            )
        );
    }
    public function delete($id)
    {
        EventModel::find($id)->delete();
        return Redirect::route('admin.events.index');
    }
}