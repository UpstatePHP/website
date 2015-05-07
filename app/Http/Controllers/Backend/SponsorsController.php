<?php
namespace UpstatePHP\Website\Http\Controllers\Backend;

use Illuminate\Http\Request;
use UpstatePHP\Website\Http\Controllers\Controller;
use UpstatePHP\Website\Domain\Sponsors\Sponsor;

class SponsorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'sponsors' => Sponsor::all(),
            'pageHeader' => 'Sponsors'
        ];

        return view('backend.sponsors.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'sponsor' => new Sponsor,
            'pageHeader' => 'Create Sponsor'
        ];

        return view('backend.sponsors.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->dispatchFromArray(
            'UpstatePHP\Website\Commands\RegisterSponsorCommand',
            array_add($request->all(), 'logo', $request->get('logo'))
        );
        return redirect()->route('admin.sponsors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function delete($id)
    {
        $sponsor = Sponsor::find($id);
        if (! is_null($sponsor->logo)) {
            \File::delete(public_path().'/uploads/'.$sponsor->logo);
        }
        $sponsor->delete();
        return redirect()->route('admin.sponsors.index');
    }

}
