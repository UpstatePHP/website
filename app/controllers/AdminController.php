<?php

class AdminController extends BaseController
{
    protected $layout = 'layouts.main';

    protected $menu;

    public function __construct()
    {
        $this->menu = App::make('menu');

        $this->menu->put('admin', [
            'items' => [
                'events' => URL::route('admin.events.index'),
                'venues' => URL::route('admin.venues.index')
            ]
        ]);
    }
}