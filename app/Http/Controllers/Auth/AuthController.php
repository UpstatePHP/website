<?php namespace UpstatePHP\Website\Http\Controllers\Auth;

use Illuminate\Http\Request;
use UpstatePHP\Website\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

class AuthController extends Controller
{

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'logout']);
	}

    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember')))
        {
            return redirect()->intended('/');
        }

        return redirect()->route('auth.login')
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $this->getFailedLoginMessage(),
            ]);
    }

    public function logout()
    {
        $this->auth->logout();

        return redirect('/');
    }

}
