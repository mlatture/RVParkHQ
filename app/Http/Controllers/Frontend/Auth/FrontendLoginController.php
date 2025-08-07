<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route as RouteFacade;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomVerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Verified;
use App\Models\User;

class FrontendLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Handle modal login request for frontend.
     */
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
            // Enforce email verification
            if (is_null($user->email_verified_at)) {
                // Generate verification URL
                $verificationUrl = URL::temporarySignedRoute(
                    'verification.verify',
                    now()->addMinutes(60),
                    ['id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification())]
                );
                // Send custom verification email
                Mail::to($user->email)->send(new CustomVerifyEmail($user, $verificationUrl));
                $this->guard()->logout();
                return redirect('/')->with([
                    'icon' => 'error',
                    'success' => 'You must verify your email address before logging in. A verification link has been sent to your email.'
                ]);
            }
            // Always redirect to frontend home page after login
            return redirect()->route('rv-park.home')->with([
                'icon' => 'success',
                'success' => 'Welcome ' . $user->name
            ]);
        }

        // If login failed
        $this->incrementLoginAttempts($request);
        return back()->withErrors([
            'email' => trans('auth.failed'),
        ])->withInput($request->only('email'));
    }

    public function showVerificationNotice()
    {
        return view('auth.verify');
    }

    public function verifyEmail($id, $hash, Request $request)
    {
        $user = User::findOrFail($id);
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }
        if ($user->hasVerifiedEmail()) {
            return redirect('/')->with([
                'icon' => 'success',
                'success' => 'Your email is already verified.'
            ]);
        }
        $user->markEmailAsVerified();
        event(new Verified($user));
        Auth::login($user);
        return redirect('/')->with([
            'icon' => 'success',
            'success' => 'Your email has been verified! You are now logged in.'
        ]);
    }

    public function resendVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with([
            'icon' => 'success',
            'success' => 'Verification link sent!'
        ]);
    }
}
