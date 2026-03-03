<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\FrontendVerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class FrontendRegisterController extends Controller
{
    use RegistersUsers;

    protected function generateUsername($name, $email)
    {
        $base = strstr($email, '@', true) ?: \Str::slug($name);
        $username = $base;
        $i = 1;
        while (\App\Models\User::where('username', $username)->exists()) {
            $username = $base . $i;
            $i++;
        }
        return $username;
    }

    /**
     * Handle modal register request for frontend user account creation.
     */
    public function registerModal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $this->generateUsername($request->name, $request->email),
            'password' => Hash::make($request->password),
            'type' => 'user',
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification())]
        );

        Mail::to($user->email)->send(new FrontendVerifyEmail($user, $verificationUrl));

        return redirect()->route('rv-park.home')->with([
            'icon' => 'success',
            'success' => 'Registration successful. Please verify your email before logging in.'
        ]);
    }

    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);
        if (! hash_equals((string) $hash, sha1($user->email))) {
            abort(403, 'Invalid verification link.');
        }
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('rv-park.home')->with([
                'icon' => 'success',
                'success' => 'Your email is already verified.'
            ]);
        }
        $user->markEmailAsVerified();
        $this->guard()->login($user);

        return redirect()->route('rv-park.home')->with([
            'icon' => 'success',
            'success' => 'Your email has been verified!'
        ]);
    }
}