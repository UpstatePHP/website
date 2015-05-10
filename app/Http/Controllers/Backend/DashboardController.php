<?php
namespace UpstatePHP\Website\Http\Controllers\Backend;

use UpstatePHP\Website\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('backend.dashboard', [
            'pageHeader' => 'Dashboard'
        ]);
    }
}