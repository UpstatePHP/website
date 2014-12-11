<?php

use Laracasts\Commander\CommanderTrait;
use UpstatePHP\Website\Sponsors\Sponsor;

class SponsorsController extends PageController
{
    use CommanderTrait;

    public function adminIndex()
    {
        $data = [
            'sponsors' => Sponsor::all()
        ];

        $this->layout->body = View::make('sponsors.admin.index', $data);
    }

    public function create()
    {
        $data = [
            'sponsor' => new Sponsor
        ];
        $this->layout->body = View::make('sponsors.admin.form', $data);
    }

    public function store()
    {
        $this->execute(
            '\UpstatePHP\Website\Sponsors\Commands\RegisterSponsorCommand',
            Input::all()
        );

        return Redirect::route('admin.sponsors.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = [
            'sponsor' => Sponsor::find($id)
        ];
        $this->layout->body = View::make('sponsors.admin.form', $data);
    }

    public function update($id)
    {
        $sponsor = Sponsor::find($id);

        $input = Input::except('_token');

        if (Input::hasFile('logo')) {
            $filename = md5(microtime()).'.jpg';

            $path = Input::file('logo')->getRealPath();
            $logo = Image::make($path);
            $logo->resize(300, null, function($constraint)
            {
                $constraint->aspectRatio();
            });
            $logo->save(public_path().'/uploads/'.$filename);

            $input['logo'] = $filename;

            if (! is_null($sponsor->logo)) {
                File::delete(public_path().'/uploads/'.$sponsor->logo);
            }
        }

        $sponsor->update($input);

        return Redirect::route('admin.sponsors.index');
    }

    public function delete($id)
    {
        $sponsor = Sponsor::find($id);

        if (! is_null($sponsor->logo)) {
            File::delete(public_path().'/uploads/'.$sponsor->logo);
        }

        $sponsor->delete();

        return Redirect::route('admin.sponsors.index');
    }

}