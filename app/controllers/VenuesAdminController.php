<?php

use UpstatePHP\Website\Models;

class VenuesAdminController extends AdminController
{

    /**
     * Display a listing of the resource.
     * GET /eventsadmin
     *
     * @return Response
     */
    public function index()
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

    }

    /**
     * Store a newly created resource in storage.
     * POST /eventsadmin
     *
     * @return Response
     */
    public function store()
    {

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
        //
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
        //
    }

}