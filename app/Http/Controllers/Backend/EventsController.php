<?php
namespace UpstatePHP\Website\Http\Controllers\Backend;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Http\Request;
use UpstatePHP\Website\Domain\Events\Event as EventModel;
use UpstatePHP\Website\Domain\Events\EventRepository;
use UpstatePHP\Website\Http\Controllers\Controller;

class EventsController extends Controller
{
    use DispatchesCommands;

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
            'event' => new EventModel,
            'eventSponsors' => []
        ];

        return view('backend.events.form', $data);
    }

    public function store(Request $request)
    {
        $this->dispatchFrom('UpstatePHP\Website\Commands\HostEventCommand', $request);
        return redirect()->route('admin.events.index');
    }

    public function edit($id)
    {
        $data = [
            'event' => EventModel::find($id)
        ];

        $data['eventSponsors'] = $data['event']->sponsors->lists('id');

        return view('backend.events.form', $data);
    }

    public function update($id, Request $request)
    {
        $this->dispatchFrom(
            'UpstatePHP\Website\Commands\UpdateHostedEventCommand',
            $request,
            ['id' => $id]
        );
        return redirect()->route('admin.events.index');
    }

    public function import()
    {
        $newEvents = $this->eventRepository->importNewRemoteEvents();
        $this->execute(
            '\UpstatePHP\Website\Events\Commands\ImportNewEventsCommand',
            ['events' => $newEvents]
        );
        return Redirect::route('backend.events.index')->with(
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
        return redirect()->route('admin.events.index');
    }
}
