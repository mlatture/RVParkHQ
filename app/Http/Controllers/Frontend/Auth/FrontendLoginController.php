<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route as RouteFacade;

class FrontendLoginController extends Controller
{
    use AuthenticatesUsers;

    public function loginModal(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            if (!$user->hasVerifiedEmail()) {
                $this->guard()->logout();
                if (RouteFacade::has('verification.notice')) {
                    return redirect()->route('verification.notice')->with([
                        'icon' => 'error',
                        'success' => 'You must verify your email address before logging in.'
                    ]);
                } else {
                    return redirect('/')->with([
                        'icon' => 'error',
                        'success' => 'You must verify your email address before logging in.'
                    ]);
                }
            }

            return redirect()->route('rv-park.home')->with([
                'icon' => 'success',
                'success' => 'Welcome ' . $user->name
            ]);
        }

        $this->incrementLoginAttempts($request);
        return back()->withErrors([
            'email' => trans('auth.failed'),
        ])->withInput($request->only('email'));
    }
}