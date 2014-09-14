<?php

use UpstatePHP\Website\Models;

class VenuesController extends PageController
{

    public function adminIndex()
    {
        $data = [
            'venues' => Models\Venue::all()
        ];

        $this->layout->body = View::make('venues.admin.index', $data);
    }

    public function create()
    {
        $data = [
            'venue' => new Models\Venue
        ];
        $this->layout->body = View::make('venues.admin.form', $data);
    }

    public function store()
    {
        Models\Venue::create(Input::except('_token'));
        return Redirect::route('admin.venues.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = [
            'venue' => Models\Venue::find($id)
        ];
        $this->layout->body = View::make('venues.admin.form', $data);
    }

    public function update($id)
    {
        Models\Venue::find($id)->update(Input::except('_token', '_method'));
        return Redirect::route('admin.venues.index');
    }

    public function delete($id)
    {
        Models\Venue::find($id)->delete();
        return Redirect::route('admin.venues.index');
    }

}