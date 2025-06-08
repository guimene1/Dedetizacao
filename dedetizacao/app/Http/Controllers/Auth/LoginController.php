<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    protected function validateLogin(\Illuminate\Http\Request $request)
    {
        $request->validate([
            $this->username() => 'required|email',
            'password' => 'required|string',
        ], [
            $this->username() . '.required' => 'O e-mail é obrigatório.',
            $this->username() . '.email' => 'Informe um e-mail válido.',
            'password.required' => 'A senha é obrigatória.',
        ]);
    }

    protected function sendFailedLoginResponse(\Illuminate\Http\Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->username()))
            ->withErrors([
                $this->username() => 'E-mail ou senha incorretos.',
            ]);
    }


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
