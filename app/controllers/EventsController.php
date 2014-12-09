<?php

use Laracasts\Commander\CommanderTrait;
use UpstatePHP\Website\Events\EventRepository;
use UpstatePHP\Website\Models;

class EventsController extends PageController
{
    use CommanderTrait;

    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function adminIndex()
    {
        $data = [
            'events' => $this->eventRepository->allEvents(20)
        ];

        $this->layout->body = View::make('events.admin.index', $data);
    }

    public function create()
    {
        $data = [
            'event' => new Models\Event
        ];
        $this->layout->body = View::make('events.admin.form', $data);
    }

    public function store()
    {
        Models\Event::create(Input::except('_token'));

        return Redirect::route('admin.events.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = [
            'event' => Models\Event::find($id),
            'venues' => Models\Venue::all()
        ];

        $this->layout->body = View::make('events.admin.form', $data);
    }

    public function update($id)
    {
        Models\Event::find($id)->update(Input::except('_token', '_method'));

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

    public function destroy($id)
    {
        Models\Event::find($id)->delete();

        return Redirect::route('admin.events.index');
    }

}