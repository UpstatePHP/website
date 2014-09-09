<?php

class PageController extends BaseController
{
    protected $layout = 'layouts.main';

    public function index()
    {
        $this->layout->body = View::make('pages.index');
    }
}