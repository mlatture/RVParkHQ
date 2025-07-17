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
     * Handle modal register request for frontend (now for claim park submission).
     */
    public function registerModal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'park_name' => ['required', 'string', 'max:255'],
            'park_url' => ['nullable', 'string', 'max:255'],
            'address_line_1' => ['nullable', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'zip' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $token = \Str::random(40);

        $submission = \App\Models\ClaimParkSubmission::create([
            'park_name' => $request->park_name,
            'park_url' => $request->park_url,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'password' => bcrypt($request->password),
            'token' => $token,
        ]);

        // Send verification email
        \Mail::to($request->email)->send(new \App\Mail\ClaimParkVerifyMail($submission));

        return redirect()->route('rv-park.home')->with([
            'icon' => 'success',
            'success' => 'A verification email has been sent. Please verify before logging in.'
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