<?php

use UpstatePHP\Website\Models;

class EventsController extends PageController
{
    public function adminIndex()
    {
        $data = [
            'events' => Models\Event::all()
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

    public function destroy($id)
    {
        Models\Event::find($id)->delete();

        return Redirect::route('admin.events.index');
    }

}