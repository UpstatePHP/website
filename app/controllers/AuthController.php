<?php

class AuthController extends PageController
{
    public function showLogin()
    {
        $this->layout->body = View::make('pages.login');
    }

    public function login()
    {
        if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')]))
        {
            return Redirect::intended('/');
        }
    }

    public function logout()
    {
        Auth::logout();

        return Redirect::to('/');
    }
}