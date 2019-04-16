<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;

class LoginController extends Controller {

use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $_user = User::find(Auth::id());
            $_user->is_loggedin = 1;
            $_user->save();
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function credentials(Request $request) {
        return array_merge($request->only($this->username(), 'password'), ['status' => 1]);
    }

    public function logout(Request $request) {
        $_user = User::find(Auth::id());
        $_user->is_loggedin = 0;
        $_user->save();
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }

}
