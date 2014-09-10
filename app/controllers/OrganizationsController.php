<?php

use UpstatePHP\Website\Models;

class OrganizationsController extends PageController
{
    public function adminIndex()
    {
        $data = [
            'organizations' => Models\Organization::all()
        ];

        $this->layout->body = View::make('organizations.admin.index', $data);
    }

    public function create()
    {
        $data = [
            'organization' => new Models\Organization
        ];
        $this->layout->body = View::make('organizations.admin.form', $data);
    }

    public function store()
    {
        $input = Input::except('_token');

        if (Input::hasFile('logo')) {
            $filename = md5(microtime()).'.jpg';

            $path = Input::file('logo')->getRealPath();
            $logo = Image::make($path);
            $logo->resize(300, null);
            $logo->save(public_path().'/images/'.$filename);

            $input['logo'] = $filename;
        }

        Models\Organization::create($input);
        return Redirect::route('admin.organizations.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = [
            'organization' => Models\Organization::find($id)
        ];
        $this->layout->body = View::make('organizations.admin.form', $data);
    }

    public function update($id)
    {
        $organization = Models\Organization::find($id);

        $input = Input::except('_token');

        if (Input::hasFile('logo')) {
            $filename = md5(microtime()).'.jpg';

            $path = Input::file('logo')->getRealPath();
            $logo = Image::make($path);
            $logo->resize(300, null);
            $logo->save(public_path().'/images/'.$filename);

            $input['logo'] = $filename;

            if (! is_null($organization->logo)) {
                File::delete(public_path().'/images/'.$organization->logo);
            }
        }

        $organization->update($input);

        return Redirect::route('admin.organizations.index');
    }

    public function delete($id)
    {
        $organization = Models\Organization::find($id);

        if (! is_null($organization->logo)) {
            File::delete(public_path().'/images/'.$organization->logo);
        }

        $organization->delete();

        return Redirect::route('admin.organizations.index');
    }

}