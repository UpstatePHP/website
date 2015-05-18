<?php namespace UpstatePHP\Website\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Orchestra\Support\Facades\Asset as Asset;

abstract class Controller extends BaseController
{
    use DispatchesCommands, ValidatesRequests;
}
