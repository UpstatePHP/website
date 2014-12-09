<?php

use UpstatePHP\Website\Events\EventRepository;
use UpstatePHP\Website\Models\Organization;

class PageController extends BaseController
{
    protected $layout = 'layouts.main';

    public function index()
    {
        $data = [
            'supporters' => Organization::supportersAndSponsors()->take(4)->get()
        ];

        $this->layout->body = View::make('pages.index', $data);
    }
}