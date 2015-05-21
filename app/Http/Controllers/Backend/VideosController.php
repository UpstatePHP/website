<?php
namespace UpstatePHP\Website\Http\Controllers\Backend;

use Illuminate\Http\Request;
use UpstatePHP\Website\Http\Controllers\Controller;
use UpstatePHP\Website\Domain\Videos\Video;

class VideosController extends Controller
{
    public function index()
    {
        $data = [
            'videos' => Video::all(),
            'pageHeader' => 'Videos'
        ];

        return view('backend.videos.index', $data);
    }

    public function create()
    {
        $data = [
            'sponsor' => new Sponsor,
            'pageHeader' => 'Create Sponsor'
        ];

        return view('backend.sponsors.form', $data);
    }

    public function store(Request $request)
    {
        $this->dispatchFromArray(
            'UpstatePHP\Website\Commands\RegisterSponsorCommand',
            array_add($request->all(), 'logo', $request->file('logo'))
        );
        return redirect()->route('admin.sponsors.index');
    }

    public function edit($id)
    {
        $data = [
            'sponsor' => Sponsor::find($id),
            'pageHeader' => 'Update Sponsor'
        ];

        return view('backend.sponsors.form', $data);
    }

    public function update($id, Request $request)
    {
        $this->dispatchFromArray(
            'UpstatePHP\Website\Commands\UpdateSponsorInfoCommand',
            array_merge(
                $request->all(),
                [
                    'logo' => $request->file('logo'),
                    'id' => $id
                ]
            )
        );
        return redirect()->route('admin.sponsors.index');
    }

    public function delete($id)
    {
        $sponsor = Sponsor::find($id);
        if (! is_null($sponsor->logo)) {
            \File::delete(public_path().'/uploads/'.$sponsor->logo);
        }
        $sponsor->delete();
        return redirect()->route('admin.sponsors.index');
    }

    public function import()
    {
        sleep(3);

        return null;
    }

}
