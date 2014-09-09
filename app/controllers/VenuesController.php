<?php

use UpstatePHP\Website\Models;

class VenuesController extends PageController
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
            'venues' => Models\Venue::all()
        ];

        $this->layout->body = View::make('venues.admin.index', $data);
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
            'venue' => new Models\Venue
        ];
        $this->layout->body = View::make('venues.admin.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     * POST /eventsadmin
     *
     * @return Response
     */
    public function store()
    {
        Models\Venue::create(Input::except('_token'));
        return Redirect::route('admin.venues.index');
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
            'venue' => Models\Venue::find($id)
        ];
        $this->layout->body = View::make('venues.admin.form', $data);
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
        Models\Venue::find($id)->update(Input::except('_token', '_method'));
        return Redirect::route('admin.venues.index');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /eventsadmin/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        Models\Venue::find($id)->delete();
        return Redirect::route('admin.venues.index');
    }

}