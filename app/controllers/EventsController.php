<?php

use UpstatePHP\Website\Models;

class EventsController extends PageController
{

    /**
     * Display a listing of the resource.
     * GET /eventsadmin
     *
     * @return Response
     */
    public function adminIndex()
    {
        $data = [
            'events' => Models\Event::all()
        ];

        $this->layout->body = View::make('events.admin.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * GET /eventsadmin/create
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'event' => new Models\Event
        ];
        $this->layout->body = View::make('events.admin.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     * POST /eventsadmin
     *
     * @return Response
     */
    public function store()
    {
        Models\Event::create(Input::except('_token'));

        return Redirect::route('admin.events.index');
    }

    /**
     * Display the specified resource.
     * GET /eventsadmin/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /eventsadmin/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'event' => Models\Event::find($id),
            'venues' => Models\Venue::all()
        ];

        $this->layout->body = View::make('events.admin.form', $data);
    }

    /**
     * Update the specified resource in storage.
     * PUT /eventsadmin/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        Models\Event::find($id)->update(Input::except('_token', '_method'));

        return Redirect::route('admin.events.index');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /eventsadmin/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Models\Event::find($id)->delete();

        return Redirect::route('admin.events.index');
    }

}