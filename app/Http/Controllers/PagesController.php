<?php namespace UpstatePHP\Website\Http\Controllers;

use UpstatePHP\Website\Domain\Pages\Page;
use UpstatePHP\Website\Domain\Sponsors\Sponsor;

class PagesController extends Controller
{
    public function index()
    {
        $data = [
            'supporters' => Sponsor::supportersAndSponsors()->take(4)->get()
        ];

        return view('pages.index', $data);
    }

    public function sponsors()
    {
        $sponsors = Sponsor::orderNaturally()->get();
        return view('pages.sponsors', compact('sponsors'));
    }

    public function catchAll($path)
    {
        $page = Page::findByPath($path);

        return view('pages.shell', compact('page'));
    }

}
